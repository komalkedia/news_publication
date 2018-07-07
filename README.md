# news_publication
A sample news publication application in Yii2 framework

Main Technologies Used:
1.	Yii2
2.	Mysql
3.	Bootstrap

Design Pattern:
Hierarchical model–view–controller (HMVC)
 
Following functionalities has been implemented in the project:
User Management:
1.	Register
2.	Send Email: (Used PHP Mailer)
3.	Reset Password
4.	Login
5.	Forgot Password


News Publishing:
1.	Create News
2.	Delete News
3.	View Own News

Newsstand:
1.	See Latest 10 News List
2.	View Article Detail
3.	Download article pdf : (Use PDF export library)

News Rss Feed Service:
1.	An Rss Feed to subscribed to, that includes 10 latest articles



Steps to setup database: 
1. Create a database : newspublishing
2. Import database from Source/newspublishing.sql
3. Go to Source\newsstand\common\config\main-local.php and change dbname, username and password according to newly created database

To Run the Source code:
1. Copy Folder "newsstand" from Source folder to <root> directory of web server, 
2. Go to <root>\newsstand\common\config\main-local.php and change mail username and password, if needed
3. Access the url http:\\localhost\newsstand. localhost can be replaced with domain name.

Work flow and Design:
1. Included pdf to describe workflow.
2. Included design document to describe code structure and functionality
