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
    CONCAT(pp.surname, " ", pp.name, " ", pp.patronymic) AS pp_fullname,
    pp.passport_id as pp_id,
    pp.residential_address as pp_residential_address,
    pp.place_of_issue as pp_place_of_issue,
    DATE_FORMAT(pp.date_of_issue, "%d.%m.%Y") as pp_date_of_issue,
    pp.town as pp_town,
    pp.tin as pp_tin,
    phones.body as phones_main,
    pp.nationality as pp_nationality,
    pp.date_of_birth as pp_date_of_birth,
    email.body as emails_main
FROM term_deposits
         INNER JOIN products on term_deposits.product_id = products.id
         INNER JOIN clients  on products.client_id = clients.id
         INNER JOIN contacts ON contacts.client_id = clients.id
         INNER JOIN phones ON phones.contact_id = contacts.id
         INNER JOIN documents d on clients.id = d.client_id
         INNER JOIN passports pp on d.id = pp.document_id
         INNER JOIN currencies cc on term_deposits.currency_id = cc.id
         INNER JOIN contract_numbers cn on term_deposits.contract_number_id = cn.id
         LEFT JOIN
            (select emails.body, contacts.client_id from contacts
                INNER JOIN emails on contacts.id = emails.contact_id and contacts.contact_type_id = 1 and client_id = ${client_id}
          limit 1) as email  ON email.client_id = ${client_id}
WHERE phones.is_main = 1 AND term_deposits.product_id = ${product_id}

