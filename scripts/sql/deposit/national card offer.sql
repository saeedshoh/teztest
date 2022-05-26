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
               LEFT JOIN questionnaires on clients.id = questionnaires.client_id
               LEFT JOIN
               (select e.body, c.client_id from contacts c
                    INNER JOIN emails e on c.id = e.contact_id and c.contact_type_id = 1
                        where client_id = ${client_id} limit 1) as email  ON email.client_id = ${client_id}
      WHERE phones.is_main = 1 AND clients.id = ${client_id} limit 1

