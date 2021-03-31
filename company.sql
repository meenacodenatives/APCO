Company name and lead name should be same -?
Which Lead converted to company - lead id- customer table
cnct_did_no,cnct_owned - ?
cmpny_type_id , domain, srvc_id,srvc_cat - Software ,college - lookup -
No need for region
srvc_id,srvc_cat-?
cnct_priority,cnct_parent-?

INSERT INTO COMPANY (cmpny_name,cmpny_has_agreement,cmpny_tier,cmpny_pay_terms,cmpny_del_req,cmpny_status,cmpny_created) 
VALUES ('KLN college',1,1,40000, 2,1,'2020-12-30 13:45:04');

INSERT INTO COMPANY_CONTACT (cmpny_name,cmpny_has_agreement,cmpny_tier,cmpny_pay_terms,cmpny_del_req,cmpny_status,cmpny_created) 
VALUES ('KLN college',1,1,40000, 2,1,'2020-12-30 13:45:04');

INSERT INTO COMPANY_CONTACT (cmpny_id,cnct_name,cnct_title,cnct_did_no,cnct_mob_no,cnct_board_no,
cnct_email_prmy,cnct_email_sndry,cnct_skype,cnct_linkedin,cnct_hiremode,	
cmpny_type_id,cnct_address,cnct_location,cnct_region,cnct_country,cnct_web,	
cnct_domain,cnct_domain_id,cnct_technology,cnct_owned,cmpgrp_name,	
srvc_id,srvc_cat,cnct_priority,cnct_parent,cnct_mode,cnct_status,	
cnct_created,cnct_last_contacted,ccstg_id,cnct_w_location)
VALUES (2,Meena,'Software Engg',9923456789,1234567891,5,'meena@codenatives.com',
'meena1@codenatives.com','meenacodenatives','meena2021','Yes','10','Nanmangalam','chennai','IST',
'India','http://sw.com','bluehost',15,'PHP','DK','Parent',20,'Hardware',25,30,'TEST','Active',
'2020-12-30 13:45:04','2021-02-05 13:45:04',35,'Mumbai');
