quiz

id, nama_quiz, book_quiz, created_at, expired_at, winner (fk user.id)



soalquiz

id, id_quiz, pertanyaan, jawaban1, jawaban2, jawaban3, jawaban4, jawabanbenar



scorequiz

id, id_quiz, id_user, score
id, id_quiz, id_user, score





global leaderboard

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
