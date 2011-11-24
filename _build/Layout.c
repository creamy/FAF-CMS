#include <fcgi_stdio.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include "mongo.h"

char *replace_str(char *str, char *orig, char *rep) {
  static char buffer[4096];
  char *p;

  if(!(p = strstr(str, orig)))  
    return str;

  strncpy(buffer, str, p-str); 
  buffer[p-str] = '\0';

  sprintf(buffer+(p-str), "%s%s", rep, p+strlen(orig));

  return buffer;
}

int main( int argc, char *argv[] ) {

	FILE *fp;
	long len;
	char *buf;
	char *request;
	char *response;

	int status;
	mongo conn[1];
	bson query[1];
	mongo_cursor cursor[1];
	bson_iterator iterator[1];
	
	status = mongo_connect( conn, "127.0.0.1", 27017 );

	fp=fopen( "/path/to/layout.html", "r" );
	fseek( fp, 0, SEEK_END ); 
	len=ftell( fp ); 
	fseek( fp, 0, SEEK_SET ); 
	buf=(char *)malloc(len); 
	fread( buf, len, 1, fp ); 
	fclose( fp );
	
	while( FCGI_Accept() >= 0 ) {

		request = getenv( "REQUEST_URI" );

		bson_init( query );
		bson_append_string( query, "page", request );
		bson_finish( query );
		
		mongo_cursor_init( cursor, conn, "fafcms.pages" );
		mongo_cursor_set_query( cursor, query );
		if ( mongo_cursor_next( cursor ) == MONGO_OK ) {
			if ( bson_find( iterator, mongo_cursor_bson( cursor ), "content" ) ) {
				sprintf( response, "%s", bson_iterator_string( iterator ) );
			} else {
				sprintf( response, "%s%s%s", "<h1>Oops. Not Found (404)</h1><p>The document ", request, " was not found on this server.</p>" );
			}
		} else {
			 sprintf( response, "%s%s%s", "<h1>Oops. Not Found (404)</h1><p>The document ", request, " was not found on this server.</p>" );
		}
	
		printf( "Content-Type: text/html\n\n" );
		printf( "%s", replace_str(buf, "<!--Content-->", response));
		mongo_cursor_destroy( cursor );

	}

	bson_destroy( query );
	mongo_destroy( conn );
	return 0;
}

