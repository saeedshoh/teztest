SELECT
    CONCAT(passports.surname, " ", passports.name, " ", passports.patronymic) as pp_fullname,
    passports.passport_id as pp_passport_id,
    passports.place_of_issue as pp_place_of_issue,
    passports.date_of_issue as pp_date_of_issue,
    passports.residential_address as pp_residential_address,
    passports.tin as pp_tin,
    passports.town as pp_town,
    phones.body as phones_main,
    email.body as email_main,
    address.body as addresses_body,
    contract_numbers.unique_id as contract_number,
    bank_accounts.contract_date as ba_contract_date
FROM bank_accounts
         INNER JOIN products ON bank_accounts.product_id = products.id
         INNER JOIN documents ON products.client_id = documents.client_id and documents.document_type_id = 1
         INNER JOIN passports ON documents.id = passports.document_id
         INNER JOIN contacts ON products.client_id = contacts.client_id and contacts.contact_type_id = 3
         INNER JOIN phones ON phones.contact_id = contacts.id
         INNER JOIN contract_numbers ON bank_accounts.contract_number_id = contract_numbers.id
         LEFT JOIN
             (select emails.body, contacts.client_id from contacts
                 INNER JOIN emails on contacts.id = emails.contact_id and contacts.contact_type_id = 1 and client_id = ${client_id}
              limit 1) as email  ON email.client_id = ${client_id}
         LEFT JOIN
             (select addresses.body, contacts.client_id from contacts
                 INNER JOIN addresses on contacts.id = addresses.contact_id and contacts.contact_type_id = 2 and client_id = ${client_id}
              limit 1) as address  ON address.client_id = ${client_id}
WHERE phones.is_main = 1 AND bank_accounts.product_id = ${product_id}