ALTER TABLE tasks ADD COLUMN user_id INT UNSIGNED;

ALTER TABLE tasks ADD CONSTRAINT tasks_to_users
    FOREIGN KEY(user_id)
    REFERENCES users(id);

-- requêtes de sélection

SELECT * FROM tasks, users WHERE user_id = users.id;

SELECT tasks.id, task_name, done, user_name as owner 
FROM tasks INNER JOIN users 
ON user_id = users.id 
-- WHERE done=1;