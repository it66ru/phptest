SELECT i.storage_id, i.category_id,
  (SELECT i2.quantity
    FROM incoming i2
    WHERE i2.storage_id = i.storage_id
      AND i2.category_id = i.category_id
    ORDER BY i2.TIME DESC LIMIT 1) AS quantity
FROM incoming i
GROUP BY i.storage_id, i.category_id
ORDER BY i.storage_id, i.category_id
