SELECT
        ROUND(st.prepayment / st.fx_at_contract_date, 2) AS st_prepayment_usd,
        (
            ROUND((
                ROUND(st.purchase_amount / st.fx_at_contract_date, 2) -
                ROUND(st.prepayment / st.fx_at_contract_date, 2) +
                ROUND(st.client_commission / fx_at_contract_date, 2)
            ) / st.free_period, 2)
        ) AS st_graceful_period,
        ROUND(st.loan_amount / st.fx_at_contract_date, 2) AS st_loan_amount,
        ROUND(st.client_commission / st.fx_at_contract_date, 2) AS st_client_commission,
        ROUND(st.prepayment / st.fx_at_contract_date, 2) AS st_prepayment,
        st.extra_days AS st_extra_days,
        st.total_period AS st_total_period,
        st.free_period AS st_free_period,
        st.fx_at_contract_date AS fx_at_contract_date,
        st.product_id AS product_id,
        DATE_FORMAT(st.contract_date, "%d.%m.%Y") AS st_contract_date,
        np.legal_name AS np_legal_name,
        cn.unique_id AS contract_number,
        cn.secondary AS cn_secondary,
        c.display_name AS c_name,
        IF(c.name= 'usd', 18, 20.04) AS annual_rate,
        CONCAT_WS(" ", pp.surname,  pp.name, pp.patronymic) AS pp_fullname,
        pp.id AS passports_id,
        pp.place_of_issue AS pp_place_of_issue,
        DATE_FORMAT(pp.date_of_issue, "%d.%m.%Y")  AS pp_date_of_issue,
        pp.residential_address AS pp_residential_address,
        pp.tin AS pp_tin,
        pp.passport_id AS pp_passport_id,
        DATE_FORMAT(scl.contract_date, "%d.%m.%Y") AS scl_contract_date,
        CONCAT_WS(" ", pp.surname,  pp.name, pp.patronymic) AS download_name
    FROM salom_tranches st
        INNER JOIN npd_conditions nc ON st.npd_condition_id = nc.id
        INNER JOIN npd_stores ns ON nc.npd_store_id = ns.id
        INNER JOIN npd_partners np ON ns.npd_partner_id = np.id
        INNER JOIN currencies c ON nc.currency_id = c.id
        INNER JOIN contract_numbers cn ON st.contract_number_id = cn.id
        INNER JOIN products p ON st.product_id = p.id
        INNER JOIN documents d ON p.client_id = d.client_id
        INNER JOIN passports pp ON d.id = pp.document_id
        INNER JOIN salom_credit_lines scl ON st.salom_credit_line_id = scl.id
WHERE st.product_id = ${product_id}