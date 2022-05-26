

/*Select * from documents
        RIGHT JOIN passports on passports.document_id = documents.id
            where documents.document_type_id = 1 and client_id = 1
UNION All
        Select * from documents
            RIGHT JOIN statements on statements.document_id = documents.id
        where documents.document_type_id = 8 and client_id = 10041*/



SELECT
    passports.surname as passports_surname,
    passports.name as passports_name,
    passports.patronymic as passports_patronymic,
    passports.passport_id as passports_id,
    DATE_FORMAT(passports.date_of_birth, "%d-%m-%Y") as passports_date_of_birth,
    passports.place_of_issue as passports_place_of_issue,
    DATE_FORMAT(passports.date_of_issue, "%d-%m-%Y") as passports_date_of_issue,
    passports.tin as passports_tin,
    passports.residential_address as passports_residential_address,
    phones.body as phones_main,
    passports.place_of_birth passports_place_of_birth,
    questionnaires.workplace as questionnaires_workplace,
    email.body as emails_main

FROM clients
         INNER JOIN documents ON documents.client_id = clients.id
         INNER JOIN passports ON passports.document_id = documents.id
         INNER JOIN contacts ON contacts.client_id = clients.id
         INNER JOIN phones ON phones.contact_id = contacts.id
         INNER JOIN nationalities ON passports.nation_id = nationalities.id
         INNER JOIN questionnaires on clients.id = questionnaires.client_id
         LEFT JOIN
     (select e.body, c.client_id from contacts c
                                          INNER JOIN emails e on c.id = e.contact_id and c.contact_type_id = 1
      where client_id = 3 limit 1) as email  ON email.client_id = 3
WHERE phones.is_main = 1 AND clients.id = 3 limit 1;

select *
from clients
         INNER JOIN documents ON documents.client_id = clients.id
         INNER JOIN passports ON passports.document_id = documents.id
         INNER JOIN contacts ON contacts.client_id = clients.id
         INNER JOIN phones ON phones.contact_id = contacts.id
         INNER JOIN nationalities ON passports.nation_id = nationalities.id
         INNER JOIN questionnaires on clients.id = questionnaires.client_id
         LEFT JOIN
             (select e.body, c.client_id from contacts c
                                                  INNER JOIN emails e on c.id = e.contact_id and c.contact_type_id = 1
              where client_id = 3 limit 1) as email  ON email.client_id = 3
where clients.id = 1