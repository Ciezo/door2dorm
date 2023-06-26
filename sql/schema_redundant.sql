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

    PRIMARY KEY(visitor_id)  
); 