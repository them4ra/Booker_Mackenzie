# Booker_Mackenzie
A very simple bookmarking utility where you can save links and arrange them with categories.

I wanted to create a bookmarking tool for myself that I was completely sure only I have access to. I think the code is so simple pretty much anyone with a little knowledge of PHP will be able to audit it to make sure it's not collecting information or sending it anywhere.

# Installation
The bookmarking utility is a LAMP application that uses a MySQL database to save all the links. 

You will need to have a server up and running with PHP and MySQL installed. Then you need to create tables using the booker.sql script that you can find in the MYSQL folder.

After this you can create a user to access the table and add the user to the connection.php section in the <b>includes</b> folder.

Default login credentials are user:changeme.
