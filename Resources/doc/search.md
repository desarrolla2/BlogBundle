#############################################################################
## data source definition
#############################################################################

source my_soruce
{
	type			= mysql
	sql_host		= localhost
	sql_user		= my_userl
	sql_pass		= my_pass
	sql_db			= my_db
	sql_port		= my_port

	sql_query		= \
		SELECT id, name, intro, content \
		FROM post \
		WHERE status = 1 \
		ORDER BY published_at DESC

	sql_query_info		= \
		SELECT name \
		FROM post \
		WHERE id=$id

}


#############################################################################
## index definition
#############################################################################


index  my_source
{
	source			= my_source
	path			= /var/lib/sphinxsearch/data/my_source
	docinfo			= extern 
	min_word_len		= 3
	charset_type		= utf-8
	html_strip		= 0
}