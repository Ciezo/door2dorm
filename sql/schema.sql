-- Create and establish entities 

-- User entities 
--    Admin, Tenant, Visitor

-- @note Admin credentials will be hardcoded
CREATE TABLE IF NOT EXISTS ADMIN (
    admin_id        INT             NOT NULL auto_increment, 
    username        VARCHAR(50)     NOT NULL,
    password        VARCHAR(50)     NOT NULL,

    PRIMARY KEY(admin_id)
); 

-- Tenant entity is used to create a profile for a tenant by an admin
CREATE TABLE IF NOT EXISTS TENANT (
    tenant_id               INT             NOT NULL auto_increment, 
    full_name               VARCHAR(255)    NOT NULL, 
    mobile_num              VARCHAR(255)    NOT NULL,
    username                VARCHAR(255)    NOT NULL, 
    email                   VARCHAR(255)    NOT NULL, 
    password                VARCHAR(255)    NOT NULL,
    emergency_contact_num   VARCHAR(255)    NOT NULL, 
    room_assign             VARCHAR(100)    NOT NULL, 
    lease_start             VARCHAR(100)    NOT NULL, 
    lease_end               VARCHAR(100)    NOT NULL, 

    -- Photo or ID of the tenant
    tenant_photo            LONGBLOB        NOT NULL, 

    PRIMARY KEY(tenant_id)
); 


-- Scheduling Visits entity facts:
--    @note This is an option for a user to schedule a visit to the site
--          Visiting facts include the following: 
--            full name, purpose of visit, time of visit, date of visit, and photo of valid
CREATE TABLE IF NOT EXISTS VISITOR (
    visitor_id      INT             NOT NULL auto_increment,
    full_name       VARCHAR(255)    NOT NULL,
    contact_no      VARCHAR(255)    NOT NULL, 
    visit_purpose   VARCHAR(255)    NOT NULL, 
    time_visit      VARCHAR(100)    NOT NULL,
    date_visit      VARCHAR(100)    NOT NULL,

    -- Photo Valid ID of visitor 
    id_visitor_photo    LONGBLOB    NOT NULL,

    PRIMARY KEY(visitor_id)  
); 

-- Available rooms entity facts: 
--   @note the available rooms shall be set by the administrator
--         and it should display on the landing page 
--         An available room has the following facts (information)
--           Room ID, Room Number, Room type, details, pricing
CREATE TABLE IF NOT EXISTS AVAILABLE_ROOMS(
    room_id        INT          NOT NULL auto_increment,
    room_number    INT          NOT NULL, 
    room_type      VARCHAR(100) NOT NULL,
    room_category  VARCHAR(100) NOT NULL,
    gender_assign  VARCHAR(100) NOT NULL,
    details        LONGTEXT     NOT NULL,
    pricing        DOUBLE       NOT NULL,
    num_of_occupants INT        NOT NULL,
    occupancy_status VARCHAR(100)   NOT NULL,
    room_photo       LONGBLOB    NOT NULL,

    PRIMARY KEY(room_id)   

    -- reference the category id  
);

CREATE TABLE IF NOT EXISTS MESSAGES (
    msg_id      INT             NOT NULL auto_increment, 
    msg_type    VARCHAR(100)    NOT NULL,
    msg_body    LONGTEXT        NOT NULL, 
    sent_by     VARCHAR(100)    NOT NULL, 
    tenant_id   INT             NOT NULL,

    PRIMARY KEY (msg_id),
    FOREIGN KEY (tenant_id) REFERENCES TENANT(tenant_id)
);

-- Payments Entity which holds all payment types
-- Payment types: 
--      (1) Rental 
--      (2) Electricity 
--      (3) Water
-- 
--  tenant_posted  this attribute is used to identify which tenant owns this payment
--  tenant_id   this attribute is used to associate an existing tenant using their ID    
CREATE TABLE IF NOT EXISTS PAYMENTS_RENTAL (
    payment_id      INT             NOT NULL auto_increment, 
    tenant_id       INT             NOT NULL,
    charges         DOUBLE          NOT NULL,
    payment_by      VARCHAR(255)    NOT NULL, 
    due_date        VARCHAR(255)    NOT NULL, 
    to_be_paid_by   VARCHAR(255)    NOT NULL,
    date_paid       VARCHAR(255)    NOT NULL,
    payment_status  VARCHAR(255)    NOT NULL,

    PRIMARY KEY (payment_id),
    FOREIGN KEY (tenant_id) REFERENCES TENANT(tenant_id)
);

CREATE TABLE IF NOT EXISTS PAYMENTS_ELECTRICITY (
    payment_id      INT             NOT NULL auto_increment, 
    tenant_id       INT             NOT NULL,
    charges         DOUBLE          NOT NULL,
    payment_by      VARCHAR(255)    NOT NULL, 
    due_date        VARCHAR(255)    NOT NULL, 
    to_be_paid_by   VARCHAR(255)    NOT NULL,
    date_paid       VARCHAR(255)    NOT NULL,
    payment_status  VARCHAR(255)    NOT NULL,

    PRIMARY KEY (payment_id),
    FOREIGN KEY (tenant_id) REFERENCES TENANT(tenant_id)
);

CREATE TABLE IF NOT EXISTS PAYMENTS_WATER (
    payment_id      INT             NOT NULL auto_increment, 
    tenant_id       INT             NOT NULL,
    charges         DOUBLE          NOT NULL,
    payment_by      VARCHAR(255)    NOT NULL, 
    due_date        VARCHAR(255)    NOT NULL, 
    to_be_paid_by   VARCHAR(255)    NOT NULL,
    date_paid       VARCHAR(255)    NOT NULL,
    payment_status  VARCHAR(255)    NOT NULL,

    PRIMARY KEY (payment_id),
    FOREIGN KEY (tenant_id) REFERENCES TENANT(tenant_id)
);

-- This Entity shall be used to represent proof of payments facts
CREATE TABLE IF NOT EXISTS PROOF_OF_PAYMENT (
    proof_id        INT             NOT NULL auto_increment, 
    tenant_id       INT             NOT NULL, 
    bill_type       VARCHAR(255)    NOT NULL,
    paid_ref_code   VARCHAR(255)    NOT NULL, 
    proof_by        VARCHAR(255)    NOT NULL,
    date_uploaded   VARCHAR(255)    NOT NULL, 
    img_proof       LONGBLOB        NOT NULL,

    PRIMARY KEY (proof_id),
    FOREIGN KEY (tenant_id) REFERENCES TENANT(tenant_id)
);

-- This Entity shall be used by the FaceNet to pull images from our remote database
CREATE TABLE IF NOT EXISTS FACE_IMG (
    face_id         INT            NOT NULL auto_increment,
    tenant_id       INT            NOT NULL, 
    tenant_name     VARCHAR(255)   NOT NULL, 
    face_status     VARCHAR(255)   NOT NULL, 
    face_capture    LONGBLOB       NOT NULL,

    PRIMARY KEY (face_id),
    FOREIGN KEY (tenant_id) REFERENCES TENANT(tenant_id)
);

-- This table is responsible for capturing all time-ins of authorized tenants
CREATE TABLE IF NOT EXISTS SECURITY_LOGS_TIME_IN (
    log_id          INT             NOT NULL auto_increment,
    tenant_name     VARCHAR(255)    NOT NULL, 
    tenant_room     VARCHAR(255)    NOT NULL, 
    date            VARCHAR(100)    NOT NULL, 
    time_in         VARCHAR(100)    NOT NULL, 
    status          VARCHAR(255)    NOT NULL, 
    capture         LONGBLOB,        

    PRIMARY KEY(log_id)
);

-- This table is for time-outs of authorized tenants
CREATE TABLE IF NOT EXISTS SECURITY_LOGS_TIME_OUT (
    log_id          INT             NOT NULL auto_increment,
    tenant_name     VARCHAR(255)    NOT NULL, 
    tenant_room     VARCHAR(255)    NOT NULL, 
    date            VARCHAR(100)    NOT NULL, 
    time_out        VARCHAR(100)    NOT NULL, 
    status          VARCHAR(255)    NOT NULL, 
    capture         LONGBLOB, 

    PRIMARY KEY(log_id)
);

-- This table is for handling fingeprint data
CREATE TABLE IF NOT EXISTS FINGERPRINT (
    id                  INT                 NOT NULL auto_increment,
    fingerprint_id      INT                 NOT NULL, 
    name                VARCHAR(255)        NOT NULL,
    date_enrolled       VARCHAR(100)        NOT NULL,
    status              VARCHAR(100)        NOT NULL, 

    PRIMARY KEY(id)
);