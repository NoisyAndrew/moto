/* raw table data */
select * from riders;
select * from members;
select * from events;
select * from bids;

/* active riders */ 
select * from riders where active;

/* bids with descriptive data from joins */
select b.bid_id, m.username, r.name, e.name, amount
from bids b
join members m on b.member_id = m.member_id
join riders r on b.rider_id = r.rider_id
join events e on b.event_id = e.event_id
;