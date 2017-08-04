create table if not exists civicrm_view_membership_terms (
id int(100) not null auto_increment,
membership_contribution_id int(100),
membership_id int(100),
membership_start_date date,
membership_end_date date,
membership_renewal_date datetime,
primary key (id)
)