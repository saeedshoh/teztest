SELECT
    CONCAT_WS(" ", passports.surname, passports.name,  passports.patronymic) AS pp_fullname,
    passports.passport_id AS pp_passport_id,
    passports.place_of_issue AS pp_place_of_issue,
    passports.date_of_issue AS pp_date_of_issue,
    passports.residential_address AS pp_residential_address,
    passports.tin AS pp_tin,
    passports.town AS pp_town,
    phones.body AS phones_main,
    email.body AS email_main,
    address.body AS address_body,
    contract_numbers.unique_id AS contract_number,
    bank_accounts.contract_date AS ba_contract_date,
    statements.fullname AS s_fullname,
    statements.shortname AS s_shortname,
    legal_entity_positions.display_name as lep_display_name,
    CONCAT_WS(" ", accountant.surname, accountant.name,  accountant.patronymic) AS  i_acc_fullname
FROM bank_accounts
         INNER JOIN products ON bank_accounts.product_id = products.id
         INNER JOIN contacts ON products.client_id = contacts.client_id AND contacts.contact_type_id = 3
         INNER JOIN phones ON phones.contact_id = contacts.id
         INNER JOIN contract_numbers ON bank_accounts.contract_number_id = contract_numbers.id
         INNER JOIN legal_entities ON products.client_id = legal_entities.client_id
         INNER JOIN representatives ON legal_entities.id = representatives.legal_entity_id
         INNER JOIN individuals ON representatives.individual_id = individuals.id
         INNER JOIN documents ON products.client_id = documents.client_id
         INNER JOIN legal_entity_positions ON representatives.legal_entity_position_id = legal_entity_positions.id
         INNER JOIN statements ON documents.id = statements.document_id
         LEFT JOIN
             (select passports.*, legal_entities.client_id, individuals.id AS doc_id
              FROM legal_entities
                       INNER JOIN representatives ON legal_entities.id = representatives.legal_entity_id AND client_id = ${client_id}
                       INNER JOIN individuals ON representatives.individual_id = individuals.id
                       INNER JOIN documents ON individuals.client_id = documents.client_id AND documents.document_type_id = 1
                       INNER JOIN passports ON documents.id = passports.document_id
              ORDER BY representatives.legal_entity_position_id
              LIMIT 1) AS passports ON passports.client_id = ${client_id}
         LEFT JOIN
             (select emails.body, contacts.client_id FROM contacts
                  INNER JOIN emails ON contacts.id = emails.contact_id AND contacts.contact_type_id = 1 AND client_id = ${client_id}
              limit 1) AS email ON email.client_id = ${client_id}
         LEFT JOIN
             (select addresses.body, contacts.client_id from contacts
                  INNER JOIN addresses ON contacts.id = addresses.contact_id AND contacts.contact_type_id = 2 AND client_id = ${client_id}
              limit 1) AS address ON address.client_id = ${client_id}
         LEFT JOIN
             (select i2.surname, i2.name, i2.patronymic, le2.client_id FROM legal_entities le2
                  INNER JOIN representatives r2 ON le2.id = r2.legal_entity_id
                  INNER JOIN individuals i2 ON r2.individual_id = i2.id WHERE r2.legal_entity_position_id = 2
             ) AS accountant ON accountant.client_id = ${client_id}
WHERE phones.is_main = 1 AND bank_accounts.product_id = ${product_id} ORDER BY legal_entity_positions.id LIMIT 1