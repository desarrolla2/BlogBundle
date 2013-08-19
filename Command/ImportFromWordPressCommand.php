<?php

namespace Desarrolla2\Bundle\BlogBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Entity\Comment;
use Desarrolla2\Bundle\BlogBundle\Entity\Link;
use Desarrolla2\DB\DB;
use Desarrolla2\DB\Adapter\MySQL;

class ImportFromWordPressCommand extends ContainerAwareCommand
{
    protected $output;
    protected $input;
    protected $db;
    protected $source;
    protected $em;

    private $n_links = 0;
    private $n_posts = 0;
    private $n_comments = 0;

    /**
     * @access protected
     * @return void
     */
    protected function configure()
    {
        $this
                ->setName('blog:import:from-wordpress')
                ->setDescription('Import Post and Comments from wordpress')
                ->addArgument('host', InputArgument::REQUIRED, 'database host')
                ->addArgument('user', InputArgument::REQUIRED, 'database user')
                ->addArgument('pass', InputArgument::REQUIRED, 'database pass')
                ->addArgument('database', InputArgument::REQUIRED, 'database name')
        ;
    }

    /**
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->input = $input;
        $this->output = $output;
        $this->em = $this->getContainer()->get('doctrine')->getEntityManager();
        $this->db = new DB;
        $this->db->setAdaper(new MySQL);
        $this->db->setOptions(array(
            'database' => $input->getArgument('database'),
            'username' => $input->getArgument('user'),
            'hostname' => $input->getArgument('host'),
            'password' => $input->getArgument('pass'),
        ));

        $this->db->connect();
    }

    /**
     * @param InputInterface  $input  Inpunt arguments
     * @param OutputInterface $output Output stream
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->cleanDatabase();
        //$this->migrateLinks();
        $this->migratePosts();
        $output->writeln('Link <info>' . $this->n_links . '</info>');
        $output->writeln('Post <info>' . $this->n_posts . '</info>');
        $output->writeln('Comments <info>' . $this->n_comments . '</info>');
    }

    protected function migrateLinks()
    {
        $links = $this->getWPLinks();
        foreach ($links as $l) {
            $link = $this->createEntityLink($l);
            $this->output->writeln($l->id . ' <info>' . $l->link_name . '</info>');
            $this->em->persist($link);
            $this->n_links ++;
            $this->em->flush();
        }
    }

    protected function migratePosts()
    {
        $ids = $this->getWPpostIds();
        foreach ($ids as $id) {
            $p = $this->getWPpost($id);
            $this->output->writeln($p->id . ' <info>' . $p->post_title . '</info>');
            $post = $this->createEntityPost($p);
            $comments = $this->getWPComments($p);
            foreach ($comments as $c) {
                $this->output->writeln($p->id . ' <comment>' . $c->comment_content . '</comment>');
                $comment = $this->createEntityComment($c);
                $comment->setPost($post);
                $this->em->persist($comment);
                $this->n_comments++;
            }
            $this->em->persist($post);
            $this->n_posts++;
            $this->em->flush();
        }
    }

    protected function cleanDatabase()
    {
        $entities = array('Comment', 'Post', 'Link');
        $entities = array('Comment', 'Post');
        foreach ($entities as $entity) {
            $query = $this->em->createQuery("DELETE FROM BlogBundle:" . $entity);
            $query->execute();
        }
    }

    protected function cleanEncode($item)
    {
        foreach ($item as $key => $value) {
            $item->$key = utf8_encode($value);
        }

        return $item;
    }

    protected function createEntityComment($c)
    {
        $c = $this->cleanEncode($c);
        $comment = new Comment();
        $comment->setUserName($c->comment_author);
        $comment->setUserEmail($c->comment_author_email);
        $comment->setUserWeb($c->comment_author_url);
        $comment->setContent($c->comment_content);
        $comment->setCreatedAt(new \DateTime($c->comment_date));
        $comment->setStatus(1);

        return $comment;
    }

    protected function createEntityPost($p)
    {
        $c = $this->cleanEncode($p);
        $post = new Post();
        $post->setName($p->post_title);
        $post->setContent($p->post_content);
        $post->setIntro($p->post_excerpt);
        $post->setCreatedAt(new \DateTime($p->post_date));
        $post->setUpdatedAt(new \DateTime($p->post_modified));
        $post->setPublishedAt(new \DateTime($p->post_date));
        $post->setIsPublished(true);

        return $post;
    }

    protected function createEntityLink($l)
    {
        $link = new Link();
        $link->setName($l->link_name);
        $link->setRss($l->link_rss);
        $link->setDescription($l->link_description);
        $link->setUrl($l->link_url);
        if ($l->link_visible == 'Y') {
            $link->setIsPublished(true);
        }

        return $link;
    }

    protected function getWPLinks()
    {
        $sql = ' SELECT ' .
                ' DISTINCT(link_url) AS link_url, ' .
                ' link_id AS id, ' .
                ' link_name AS link_name,  ' .
                ' link_description AS link_description,' .
                ' link_visible AS link_visible, ' .
                ' link_rss AS link_rss ' .
                ' FROM wp_links ';

        return $this->db->fetch_objects($sql);
    }

    protected function getWPComments($p)
    {
        $sql = ' SELECT ' .
                ' comment_author AS comment_author, ' .
                ' comment_author_email AS comment_author_email,  ' .
                ' comment_date AS comment_date,' .
                ' comment_content AS comment_content, ' .
                ' comment_author_url AS comment_author_url ' .
                ' FROM wp_comments ' .
                ' WHERE comment_post_ID = ' . $p->id .
                ' AND comment_approved  = 1 ';

        return $this->db->fetch_objects($sql);
    }

    protected function getWPpostIds()
    {
        $sql = ' SELECT ' .
                ' ID AS id ' .
                'FROM wp_posts ' .
                ' WHERE post_parent = 0 ' .
                ' AND ( post_type = \'page\' OR post_type = \'post\' ) ' .
                ' AND ( post_status = \'publish\' ) ';

        return $this->db->fetch_objects($sql);
    }

    protected function getWPpost($id)
    {
        $sql = ' SELECT ' .
                ' ID AS id, ' .
                ' post_title AS post_title, ' .
                ' post_content AS post_content, ' .
                ' post_excerpt AS post_excerpt, ' .
                ' post_date AS post_date , ' .
                ' post_modified AS post_modified, ' .
                ' post_status AS status ' .
                ' FROM wp_posts ' .
                ' WHERE id = ' . $id->id;

        return $this->db->fetch_object($sql);
    }

}
