tantangan

id, id_penantang, id_tertantang, created_at, winner




scoretantangan

id, id_tantangan, id_user, score
id, id_tantangan, id_user, score





leaderboard

id (AI), user_id (fk user.id), score(int), created_at(timestamps)




monthly winner

id (AI), user_id (fk user.id), score(int), month(int), year(int)



Library

id(AI), user_id(fk user.id), book_id(fk book.id)



tantangan winner will get 20 point on leaderboard, while reading each book give 40 point

admin can't use the quiz feature, and will not getting the point as it will break the rule of "admin can't get the present for theirself"


- Functional Leaderboard
- Add to Library
- Quiz
