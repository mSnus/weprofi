SELECT  COUNT2(distinct users.id) AS user_count
       ,subspecs.title            AS subspec_title
       ,user_spec.subspec_id      AS id
FROM `specs`
LEFT JOIN `user_spec`
ON `user_spec`.`spec_id` = `specs`.`id`
LEFT JOIN `users`
ON `user_spec`.`user_id` = `users`.`id`
LEFT JOIN `subspecs`
ON `user_spec`.`subspec_id` = `subspecs`.`id`
WHERE `users`.`status` = active
AND `user_spec`.`spec_id` = 28
GROUP BY  user_spec.spec_id
         ,id
ORDER BY `subspecs`.`title` asc