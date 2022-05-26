Select client_secret_codes.question,
       client_secret_codes.answer,
       passports.passport_id,
       passports.date_of_birth,
       passports.place_of_issue,
       passports.date_of_issue,
       passports.tin,
       passports.residential_address,
       passports.surname,
       passports.name,
       passports.patronymic,
       phones.body,
       nationalities.tj
FROM client_secret_codes
       INNER JOIN documents ON documents.client_id = client_secret_codes.client_id
       INNER JOIN passports ON passports.document_id = documents.id
       INNER JOIN contacts ON contacts.client_id = client_secret_codes.client_id
       INNER JOIN phones ON phones.contact_id = contacts.id
       INNER JOIN nationalities ON passports.nation_id = nationalities.id
       Where client_secret_codes.client_id = 702 AND phones.is_main = 1