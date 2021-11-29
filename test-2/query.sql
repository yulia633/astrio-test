SELECT
    w.first_name,
    w.last_name,
    c.model,
    GROUP_CONCAT(ch.name) AS child_data
FROM
    worker w
    LEFT JOIN car c ON c.worker_id = w.id
    LEFT JOIN child ch ON ch.worker_id = w.id
WHERE
    c.id IS NOT NULL
GROUP BY
    w.first_name,
    w.last_name,
    c.model
