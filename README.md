# Cooking-Website
The start page is recipes.php.

dbconnection.php is about database connection.

dataset.txt creates the tables and insert.sql inserts the test data.

## ER Diagram
<img width="783" alt="screen shot 2017-06-27 at 12 09 22 am" src="https://user-images.githubusercontent.com/12582993/27570543-05b21888-5acd-11e7-8e89-7fee2ecba033.png">

## Functions
It uses bootstrap to write navigation bar in every page to have easy access to the user’s
home, all the recipes, recipes that contains the specific tag, all the groups, his profile updation,
recipes searching and sign out. Especially, by clicking the categories, it will show all the tags
saved in the database. If the user click one of them, it will search all the recipes that have that
tag.


The start point of the web is a page containing only two options: register or log in. If we
click register, you can register a new account and then log in to your homepage. In the
homepage, the user can see his user name, all the meetings he has RSVPed, the 5 most
recently visited recipes, all the groups he has joined, all the recipes he has posted. Besides, all
the recipes, groups, users and meetings link to a page that describes them in more details. On
the right side, there are four buttons: post recipe, create group, update profile and view all
groups. By clicking them you can achieve related function. In this page the user can also type
some keywords and search for the recipes whose title contains the keywords.


In the recipes page, the user can see a list of recipes that meet his requirements.
Recipes with pictures are on the top and those without pictures are on the bottom. User can see
a picture, its title, the user’s name who posted it, description and a button writing more. By
clicking that button or the picture the user can visit a more detailed page about that recipe. In
this page, her can see all the information of this recipe including its ingredients, tags, pictures,
reviews and related recipes. On the right side there is a button adding a review.


Similarly, the user can click review’s title visiting a more detailed page about that review,
including a title, a rating, all the pictures, review time, description and suggestion.
In the groups page, the user can see a list of groups. By click its name, the user can
access to group’s page showing all its meetings and members. If the user hasn’t joined this
group, there is a button for him to join the group. If he has , there is a button to organize new
meetings for the members. Click on the meeting title and it will go to the meeting page. Note
that every one can see the meeting’s reports. The page shows the description, all its RSVPed
members and reports. If the user has RSVPed, he can add a report. If he has not, and he is a
member of the group, he can rsvp it. If he is not a member of the group, he will have no choice.
Note that if a user creates a new group, he will automatically become the member. The same
goes to creating a new meeting.


And the user can visit any other user’s homepage by click its uname if it appears on the
current page. This page shows you his/her profile, groups, meetings, recently visited recipes
and recipes he or she posted.


After playing around the web, the user can sign out from the homepage. The page will
link to our start point: the login page.
