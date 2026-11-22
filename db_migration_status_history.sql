ALTER TABLE services
MODIFY device_type ENUM('Laptop','PC','PC / Komputer','MacBook') NOT NULL;

UPDATE services
SET device_type = 'PC / Komputer'
WHERE device_type = 'PC';

ALTER TABLE services
MODIFY device_type ENUM('Laptop','PC / Komputer','MacBook') NOT NULL;

CREATE TABLE IF NOT EXISTS service_status_history (
  id int(11) NOT NULL AUTO_INCREMENT,
  service_id int(11) NOT NULL,
  status enum('pending','proses','selesai','diambil') NOT NULL,
  changed_by int(11) DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id),
  KEY idx_status_history_service (service_id),
  KEY idx_status_history_user (changed_by),
  CONSTRAINT fk_status_history_service FOREIGN KEY (service_id) REFERENCES services (id) ON DELETE CASCADE,
  CONSTRAINT fk_status_history_user FOREIGN KEY (changed_by) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO service_status_history (service_id, status, changed_by, created_at)
SELECT s.id, s.status, NULL, s.created_at
FROM services s
WHERE NOT EXISTS (
  SELECT 1
  FROM service_status_history h
  WHERE h.service_id = s.id
);
