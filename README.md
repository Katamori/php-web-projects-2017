# Katamori's php project server

Until I'm too busy to write a proper documentation, here's a loose description of this repo.

-------------------------------------------

Because of some unchecked circumstances and the need of a specially defined "keys.php" file
that I do not share in this repo due to safety concerns, I'm quite unsure about the running
capabilities of this server on localhost so far.

In the future, I'm going to solve it - until that, consider this repo as the source code of
                                                                http://www.katamori.16mb.com

-------------------------------------------

Some very-very simple documentation on the structure of the server, to make myself, and potentially,
anyone downloading it from GitHub a bit less confused on the usage of it.

Technical info:

- the site contains *quite little* HTML content and almost entirely lacks CSS so far
    - the reason behind it is that currently I'm focusing on backend functionality with all my capacities
- sessions defined by myself are stored in $_SESSION['custom']

Descriptions themselves:

- index.php has the obvious function: that is a main page.
    - it's fairly possible I'll make it back to a simple plain HTML as I have no need to use php there.

- login.php contains two login forms to various services
    - login forms do not appear if according to the session variables, the user is logged in

- the original project contains a "php" folder as well, which is ignored by Git by security reasons.
    - a "keys.php" file must exist here, though, otherwise certain features won't work
        - I'm definitely to add some description about it in the future

- /html_blocks contains code parts to be echoed by php under certain sufficient conditions
    - currently it contains only two login forms to be loaded later

- /hostinger folder contains the stuff I design to be used from remote access at katamori.16mb.com
    - index.php contains a login form that sends database login info to "/hostinger/redirect.php"
    - every script using database queries must include "/hostinger/dbjoin.php" at the beginning
    - db_doom.php contains a jQuery script that, via a checkbox, changes between AJAX and regular submission
        - it is done by jQuery, which occasionally turn the "submit" event listener on and off

- /myanimelist contains stuff I want to do with the MyAnimeList.net API
    - "index.php" contains the login form that then tries establishing authorization via "/myanimelist/mal_auth.php"
        - "/myanimelist/mal_auth.php" gets the redirect "names" through the dropdown list's names
        - moreover, this file must not contain any additional HTML code 
    - after login "/myanimelist/watchlist.php" lists the user's anime watchlist