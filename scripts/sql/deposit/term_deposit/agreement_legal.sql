SELECT
    term_deposits.amount as td_amount,
    term_deposits.ratio as td_ratio,
    DATE_FORMAT(term_deposits.start_contract_date, "%d.%m.%Y") as td_contract_date,
    DATE_FORMAT(term_deposits.end_contract_date, "%d.%m.%Y") as td_end_contract_date,
    PERIOD_DIFF(DATE_FORMAT(term_deposits.end_contract_date, "%Y%m"), DATE_FORMAT(term_deposits.start_contract_date, "%Y%m")) AS td_durations,
    IF(
        PERIOD_DIFF(DATE_FORMAT(term_deposits.end_contract_date, "%Y%m"), DATE_FORMAT(term_deposits.start_contract_date, "%Y%m")) <= 9,
        DATE_FORMAT(term_deposits.start_contract_date, "%d.%m.%Y"),
        DATE_FORMAT(DATE_SUB(term_deposits.end_contract_date, INTERVAL 3 MONTH),  "%d.%m.%Y")
    ) as td_top_up_date,
    cc.display_name as cc_display_name,
    cn.unique_id as contract_number,
    phones.body as phones_main,
    sm.fullname as sm_fullname,
    CONCAT(sm.legal_entity_type, ' ', sm.fullname) as sm_fullname_ru,
    sm.address as sm_address,
    sm.tin as sm_tin,
    sm.sin as sm_sin,
    CONCAT(i.surname, ' ', i.name, ' ', i.patronymic) as i_fullname,
    email.body as emails_main,
    CONCAT(accountant.surname, ' ', accountant.name, ' ', accountant.patronymic) as i_acc_fullname
FROM term_deposits
         INNER JOIN products on term_deposits.product_id = products.id
         INNER JOIN clients  on products.client_id = clients.id
         INNER JOIN contacts ON contacts.client_id = clients.id
         INNER JOIN phones ON phones.contact_id = contacts.id
         INNER JOIN documents d ON clients.id = d.client_id
         INNER JOIN statements sm ON d.id = sm.document_id
         INNER JOIN currencies cc ON term_deposits.currency_id = cc.id
         INNER JOIN contract_numbers cn ON term_deposits.contract_number_id = cn.id
         INNER JOIN legal_entities le ON clients.id = le.client_id
         INNER JOIN representatives r ON le.id = r.legal_entity_id
         INNER JOIN legal_entity_positions lep on r.legal_entity_position_id = lep.id
         INNER JOIN individuals i ON r.individual_id = i.id
         LEFT JOIN
            (select i2.surname, i2.name, i2.patronymic, le2.client_id from legal_entities le2
                    INNER JOIN representatives r2 ON le2.id = r2.legal_entity_id
                    INNER JOIN individuals i2 on r2.individual_id = i2.id where r2.legal_entity_position_id = 2
            ) as accountant ON accountant.client_id = ${client_id}
         LEFT JOIN
             (select emails.body, contacts.client_id from contacts
              INNER JOIN emails ON contacts.id = emails.contact_id and contacts.contact_type_id = 1 and client_id = ${client_id}
              limit 1) as email  ON email.client_id = ${client_id}
WHERE d.document_type_id = 8 AND phones.is_main = 1 AND term_deposits.product_id = ${product_id} order by r.legal_entity_position_id limit 1

