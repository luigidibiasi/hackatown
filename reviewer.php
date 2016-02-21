<h2>Goal of the project</h2>
Knowledge project is borned with the goal to implement a data driven social network. The idea behind the project is to let users post news, messages, photos or other(freely, without any fixed schema) and to implement in it an algorithm that extract relevant informations(thanks to geolocalization and what's posted) and to show to the user who use the service what happen in that moment in his place and what users are near to him

<h2>What we've implemented</h2>
For the hackathon we have implemented a little posting service who use localization of the user at the time he write. The user can visualize what happen in a specific rage(can be modified) trough his position. We've implemented also a version really basic of TF IDF to extract most relevants words to POST localized near the user. So we tried to enfasize on what should be the final behaviour of our project. Obviously in 48 hours it's impossible to implement complexed algorithm but TF IDF is yet an idea on what happen). when system is used and a lot of news are pushed into the emerging behaviour is to show most important words given a position and a certain rage.


<h3>Geolocalized chat</h3>
Aside of the creation of the most important news given a place we've implemented only a login in a geolocalized chat. This chat should let users in a given geografic region talk without the help of systems like facebook or others(adding friends etc.) 


<h3>Future implementations</h3>
Surely the first implementation we aim to put in production is that one of a journal event driven in which everyone who publish will not have to worry about partitioning news. The system will give users the news that are much interesting for them.


