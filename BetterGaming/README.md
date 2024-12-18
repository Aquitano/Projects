
#  Welcome to BetterGaming's ReadMe!
Hi! This is the README.md file of the BetterGaming project.
BetterGaming is a semi functional commerce shop for video games. It has a landing page, a search bar, a fully functional account system, a fully functional shopping cart and a semi functional buy process.

**Note:**
All database connections are not configured. Configure connection in search.php & dbh-inc.php. <br />
Database export file: [**BetterGaming.sql**](https://github.com/Aquitano/Projects/blob/main/BetterGaming/BetterGaming.sql) (all personal information in the database are removed.)
## Demo
**Note:** Charset can not be configured properly in the demo due to limitations of used free server hoster. <br />
[Demo-Link](https://bettergaming.thomasbreindl.me/?i=1)
#  Used Technologies/Languages
###  Frontend:
- HTML
- CSS
- TailWind Framework
- JavaScript
- PHP (dynamically generates pages like single game page, all games page, account page and shopping list)
###  Backend:
- JavaScript (ajax)
- PHP
- MariaDB/SQL
#  Folders Structure
./css/ - CSS files for the website <br />
./img/ - Images for the website <br />
./includes/ - PHP Scripts for communication with backend/database <br />
./js/ - JavaScript files for the website <br />
./utilities/ - PHP Script for generating test database/test data set
#  Features
- animated landing page with a search bar, list of featured video games, most recently added games and other information about the webpage
- all games page with live search bar (ajax) and different sorting options
- dynamic single game page with all information in the database about the specific game (availability, price, title, description, images, categories)
