SELECT * FROM matching_course m
INNER JOIN semester s on m.sem_id = s.sem_id
INNER JOIN course c on m.course_id = c.course_id
INNER JOIN day_work d on m.t_date = d.id
LEFT JOIN ta_request t ON t.m_course_id = m.m_course_id
WHERE user_id = 2 and m.deleted = 0 AND t.request_id IS NOT null
ORDER BY s.sem_number,m.m_ststus