#############################################################################
## data source definition
#############################################################################

source planetubuntu
{
	type			= mysql
	sql_host		= localhost
	sql_user		= root
	sql_pass		= password
	sql_db			= database
	sql_port		= 3306

	sql_query		= \
                SELECT p.id, \
                p.id AS id, \
                p.name AS name, \
                GROUP_CONCAT(t.name) tags, \
                p.source AS source, \
                p.intro AS intro, \
                p.content AS content, \
                TO_SECONDS(p.published_at) AS published_at \
                FROM post p \
                JOIN post_tag pt ON (p.id = pt.post_id) \
                JOIN tag t ON (t.id = pt.tag_id) \
                WHERE status = 1  \
                GROUP BY id

	sql_attr_uint 		= id
	sql_attr_timestamp	= published_at

	sql_query_info	= \
		SELECT name \
		FROM post \
		WHERE id=$id


}


#############################################################################
## index definition
#############################################################################


index planetubuntu_idx
{
	source			    = planetubuntu
	path			    = /var/lib/sphinx/planetubuntu
	docinfo			    = extern 
	min_word_len		= 3
	charset_type		= utf-8
	html_strip		    = 0
}
