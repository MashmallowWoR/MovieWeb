check video here to see the output of the project:
https://www.youtube.com/watch?v=RLxQwIjR34s&t=1s


I initially used some CSS stylesheet from external link. But since I cannot pack all the content from the link into the submission folder I just comment all the links out and now website looks more plain.

In Movieinformation.php file, I mean to display user comment differently if the movie has no review yet like the demo did. But for some reason, the 
if (mysqli_num_rows($result7a)==0) 
Is not being checked and the result for that if condition is always false.
When I use 
if (mysql_num_rows($result7a)==0) 
The if condition is always true.
I saw answers online showing use those if statement but seems not working.



