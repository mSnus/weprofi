/* add subcategories */

INSERT INTO subspecs (title, content, synonims, spec_id, ordering) 
(
SELECT CONCAT(title, ' (все)'), '', synonims, specs.id, '1' from `specs`
)

/* set user subcategories from 0 to new ones */
update user_spec set subspec_id = (
select id from subspecs where ordering=1 and subspecs.spec_id=user_spec.spec_id limit 1
)
where subspec_id = 0