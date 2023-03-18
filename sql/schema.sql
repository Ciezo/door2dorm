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

    -- Photo or ID of the tenant
    tenant_photo            LONGBLOB        NOT NULL, 

    PRIMARY KEY(tenant_id)
); 

-- IMG TABLE to store tenant photo
-- This is an associative table which is used to directly store images of 
-- registered tenants.
-- This Entity shall be used to directly query images and render on an element
CREATE TABLE IF NOT EXISTS IMG_TENANT_ASSOC(
    img_id          INT             NOT NULL auto_increment, 
    tenant_name     VARCHAR(255)    NOT NULL,
    img_ref         INT             NOT NULL,
    tenant_img      LONGBLOB        NOT NULL,

    PRIMARY KEY(img_id)
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

-- Category of Rooms facts
-- Ac rooms
-- - All gender
-- - Male
-- - Female

-- Fan rooms
-- - All gender
-- - Male
-- - Female 
-- CREATE TABLE IF NOT EXISTS ROOM_CATEG(); 

CREATE TABLE IF NOT EXISTS MESSAGES (
    msg_id      INT             NOT NULL auto_increment, 
    msg_type    VARCHAR(100)    NOT NULL,
    msg_body    LONGTEXT        NOT NULL, 
    sent_by     VARCHAR(100)    NOT NULL, 
    tenant_id   INT             NOT NULL,

    PRIMARY KEY (msg_id),
    FOREIGN KEY (tenant_id) REFERENCES TENANT(tenant_id)
);