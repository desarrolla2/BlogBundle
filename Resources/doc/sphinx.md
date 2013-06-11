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
		SELECT id AS id, \
		TO_SECONDS(published_at) AS published_at, \
		name AS name, \
		intro AS intro, \
		content AS content \
		FROM post \
		WHERE status = 1 

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
