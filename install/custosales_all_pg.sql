--
-- PostgreSQL database dump
--

-- Dumped from database version 13.5
-- Dumped by pg_dump version 13.5

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: call_types; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.call_types (
    call_type_id integer NOT NULL,
    call_type_name text,
    call_type_description text
);


ALTER TABLE public.call_types OWNER TO custosales;

--
-- Name: call_types_call_type_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.call_types ALTER COLUMN call_type_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.call_types_call_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: calling_lists; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.calling_lists (
    calling_list_id integer NOT NULL,
    calling_list_name text NOT NULL,
    calling_list_table_name text,
    calling_list_owner_id integer,
    calling_list_comments text
);


ALTER TABLE public.calling_lists OWNER TO custosales;

--
-- Name: calling_lists_calling_list_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.calling_lists ALTER COLUMN calling_list_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.calling_lists_calling_list_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: callinglists; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.callinglists (
    callinglist_id integer NOT NULL,
    callinglist__name text,
    callinglist_table_name text,
    callinglist_owner_id integer,
    callinglist_comments text
);


ALTER TABLE public.callinglists OWNER TO custosales;

--
-- Name: callinglists_callinglist_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.callinglists ALTER COLUMN callinglist_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.callinglists_callinglist_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: calls; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.calls (
    call_id integer NOT NULL,
    company_regnumber text,
    contact_id integer,
    contact_time timestamp without time zone,
    result text,
    notes text,
    call_type_id integer
);


ALTER TABLE public.calls OWNER TO custosales;

--
-- Name: calls_call_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.calls ALTER COLUMN call_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.calls_call_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: companies; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.companies (
    company_id integer NOT NULL,
    company_name text,
    company_status_id integer,
    company_type text,
    company_email text,
    company_phone text,
    company_address text,
    company_zip text,
    company_city text,
    company_county text,
    company_date_registered date,
    company_manager text,
    branch_code text,
    branch_text text,
    last_contacted date,
    contact_again date,
    currency_id integer,
    company_comments text,
    reg_date timestamp without time zone,
    sales_rep_id integer,
    calling_list_id integer,
    company_web text
);


ALTER TABLE public.companies OWNER TO custosales;

--
-- Name: companies_company_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.companies ALTER COLUMN company_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.companies_company_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: company_status; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.company_status (
    company_status_id integer NOT NULL,
    company_status_name text,
    company_status_description text,
    company_status_icon text
);


ALTER TABLE public.company_status OWNER TO custosales;

--
-- Name: company_status_company_status_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.company_status ALTER COLUMN company_status_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.company_status_company_status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: contact_types; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.contact_types (
    contact_type_id integer NOT NULL,
    contact_type_name text,
    contact_type_description text
);


ALTER TABLE public.contact_types OWNER TO custosales;

--
-- Name: contact_types_contact_type_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.contact_types ALTER COLUMN contact_type_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.contact_types_contact_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: contacts; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.contacts (
    contact_id integer NOT NULL,
    contact_type_id integer,
    contact_company_id integer,
    contact_first_name text NOT NULL,
    contact_last_name text NOT NULL,
    contact_position text,
    contact_phone text,
    contact_email text,
    contact_address text,
    contact_zip text,
    contact_city text,
    sales_rep_id integer,
    contact_comments text
);


ALTER TABLE public.contacts OWNER TO custosales;

--
-- Name: contacts_contact_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.contacts ALTER COLUMN contact_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.contacts_contact_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: currencies; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.currencies (
    currency_id integer NOT NULL,
    currency_name text NOT NULL,
    currency_symbol text NOT NULL,
    default_currency boolean
);


ALTER TABLE public.currencies OWNER TO custosales;

--
-- Name: currencies_currency_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.currencies ALTER COLUMN currency_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.currencies_currency_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: departments; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.departments (
    department_id integer NOT NULL,
    department_name text,
    workplace_id integer,
    manager_id integer,
    super_department_id integer
);


ALTER TABLE public.departments OWNER TO custosales;

--
-- Name: departments_department_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.departments ALTER COLUMN department_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.departments_department_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: document_types; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.document_types (
    document_type_id integer NOT NULL,
    document_type_name text NOT NULL,
    document_type_type text,
    document_type_icon text,
    document_type_comments text
);


ALTER TABLE public.document_types OWNER TO custosales;

--
-- Name: document_types_document_type_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.document_types ALTER COLUMN document_type_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.document_types_document_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: documents; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.documents (
    document_id integer NOT NULL,
    document_name text,
    document_type_id integer,
    document_file_name text,
    document_path text,
    document_owner_id integer,
    document_comments text,
    document_reg_date timestamp without time zone
);


ALTER TABLE public.documents OWNER TO custosales;

--
-- Name: documents_document_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.documents ALTER COLUMN document_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.documents_document_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: order_stages; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.order_stages (
    order_stage_id integer NOT NULL,
    order_stage_name text NOT NULL,
    order_stage_description text,
    order_stage_comments text
);


ALTER TABLE public.order_stages OWNER TO custosales;

--
-- Name: order_stages_order_stage_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.order_stages ALTER COLUMN order_stage_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.order_stages_order_stage_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: orders; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.orders (
    order_id integer NOT NULL,
    customer_id integer,
    order_date date,
    order_stage_id integer,
    sales_rep_id integer,
    customer_contact_id integer,
    unit_price integer,
    items integer,
    product_id integer,
    credit_days integer,
    other_terms text,
    comments text,
    regdate timestamp without time zone
);


ALTER TABLE public.orders OWNER TO custosales;

--
-- Name: orders_order_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.orders ALTER COLUMN order_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.orders_order_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: preferences; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.preferences (
    company_id integer NOT NULL,
    company_reg_number text,
    company_name text,
    company_address text,
    company_zip text,
    company_city text,
    company_country text,
    company_phone text,
    company_email text,
    company_internet text,
    default_currency_id integer,
    default_credit_days integer,
    company_bank_account text,
    company_manager_id integer
);


ALTER TABLE public.preferences OWNER TO custosales;

--
-- Name: preferences_company_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.preferences ALTER COLUMN company_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.preferences_company_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: product_categories; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.product_categories (
    product_category_id integer NOT NULL,
    product_category_name text NOT NULL,
    product_categpry_description text,
    product_category_owner_id integer,
    product_category_super_id integer,
    product_category_active boolean
);


ALTER TABLE public.product_categories OWNER TO custosales;

--
-- Name: product_categories_product_category_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.product_categories ALTER COLUMN product_category_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.product_categories_product_category_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: products; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.products (
    product_id integer NOT NULL,
    product_name text NOT NULL,
    product_description text,
    product_category_id integer,
    count_based boolean,
    unit_price integer,
    currency_id integer,
    standard_terms text,
    department_id integer,
    product_owner_id integer,
    active boolean,
    product_number text,
    in_stock boolean,
    comments text
);


ALTER TABLE public.products OWNER TO custosales;

--
-- Name: products_product_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.products ALTER COLUMN product_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.products_product_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: project_categories; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.project_categories (
    project_category_id integer NOT NULL,
    project_category_name text NOT NULL,
    comments text
);


ALTER TABLE public.project_categories OWNER TO custosales;

--
-- Name: project_categories_project_category_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.project_categories ALTER COLUMN project_category_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.project_categories_project_category_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: projects; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.projects (
    project_id integer NOT NULL,
    project_name text NOT NULL,
    project_decription text,
    project_start_date date,
    project_end_date date,
    project_client_id integer,
    project_owner_id integer,
    comments text,
    project_category_id integer
);


ALTER TABLE public.projects OWNER TO custosales;

--
-- Name: projects_project_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.projects ALTER COLUMN project_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.projects_project_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: roles; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.roles (
    role_id integer NOT NULL,
    role_name character varying(255) NOT NULL,
    role_description text NOT NULL,
    supervisor_rights boolean NOT NULL
);


ALTER TABLE public.roles OWNER TO custosales;

--
-- Name: roles_role_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.roles ALTER COLUMN role_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.roles_role_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: sales_stages; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.sales_stages (
    sales_stage_id integer NOT NULL,
    sales_stage_name text NOT NULL,
    sales_stage_description text,
    sales_stage_icon text,
    sales_stage_comments text
);


ALTER TABLE public.sales_stages OWNER TO custosales;

--
-- Name: sales_stages_sales_stage_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.sales_stages ALTER COLUMN sales_stage_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.sales_stages_sales_stage_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: settings; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.settings (
    own_company_id integer NOT NULL,
    chat_domain text,
    default_currency_id integer,
    bank_name text,
    bank_account text,
    default_credit_days integer,
    manager_id integer,
    main_office_id integer
);


ALTER TABLE public.settings OWNER TO custosales;

--
-- Name: template_categories; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.template_categories (
    template_category_id integer NOT NULL,
    template_category_name text NOT NULL
);


ALTER TABLE public.template_categories OWNER TO custosales;

--
-- Name: template_categories_template_category_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.template_categories ALTER COLUMN template_category_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.template_categories_template_category_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: templates; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.templates (
    template_id integer NOT NULL,
    template_name text NOT NULL,
    template_category_id integer,
    template_content text,
    template_explanation text,
    template_owner_id integer,
    reg_date timestamp without time zone
);


ALTER TABLE public.templates OWNER TO custosales;

--
-- Name: templates_template_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.templates ALTER COLUMN template_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.templates_template_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: titles; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.titles (
    title_id integer NOT NULL,
    title text,
    description text,
    manager boolean
);


ALTER TABLE public.titles OWNER TO custosales;

--
-- Name: titles_title_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.titles ALTER COLUMN title_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.titles_title_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: user_role; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.user_role (
    user_id integer NOT NULL,
    role_id integer NOT NULL,
    from_date date NOT NULL,
    to_date date NOT NULL,
    CONSTRAINT user_role_check CHECK ((from_date < to_date))
);


ALTER TABLE public.user_role OWNER TO custosales;

--
-- Name: users; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.users (
    user_id integer NOT NULL,
    username character varying(255) NOT NULL,
    first_name character varying(255) NOT NULL,
    last_name character varying(255) NOT NULL,
    department_id integer,
    user_email character varying(255),
    password character varying(100) NOT NULL,
    enabled boolean NOT NULL,
    start_date date,
    end_date date,
    phone character varying(255),
    mobile_phone character varying(255),
    address character varying(55),
    zipcode character varying(100),
    city character varying(255),
    skills text,
    signed_contract boolean,
    contract_id integer,
    documents character varying(255),
    supervisor_id integer,
    workplace_id integer,
    user_comments text,
    title_id integer
);


ALTER TABLE public.users OWNER TO custosales;

--
-- Name: users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.users ALTER COLUMN user_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.users_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: workhours; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.workhours (
    workhour_id integer NOT NULL,
    stamp_type text,
    stamp timestamp without time zone,
    user_id integer,
    CONSTRAINT workhours_stamp_type_check CHECK ((stamp_type = ANY (ARRAY['i'::text, 'o'::text])))
);


ALTER TABLE public.workhours OWNER TO custosales;

--
-- Name: workhours_workhour_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.workhours ALTER COLUMN workhour_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.workhours_workhour_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: workplaces; Type: TABLE; Schema: public; Owner: custosales
--

CREATE TABLE public.workplaces (
    workplace_id integer NOT NULL,
    workplace_name text NOT NULL,
    workplace_address text,
    workplace_zip text,
    workplace_city text,
    manager_id integer,
    workplace_description text,
    main_office boolean
);


ALTER TABLE public.workplaces OWNER TO custosales;

--
-- Name: workplaces_workplace_id_seq; Type: SEQUENCE; Schema: public; Owner: custosales
--

ALTER TABLE public.workplaces ALTER COLUMN workplace_id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.workplaces_workplace_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Data for Name: call_types; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.call_types (call_type_id, call_type_name, call_type_description) FROM stdin;
2	telefon ut	Oppringning av kontakt fra oss
3	telefon inn	Oppringning av oss fra kontakt
4	brev ut	Brev sendt til kontakt fra oss
5	brev inn	Brev sendt til oss fra kontakt
6	sms inn	Sms sendt til oss fra kontakt
7	sms ut	Sms sendt til kontakt fra oss
1	epost ut	Epost sendt til kontakt
8	epost inn	Epost sendt til oss fra kontakt
\.


--
-- Data for Name: calling_lists; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.calling_lists (calling_list_id, calling_list_name, calling_list_table_name, calling_list_owner_id, calling_list_comments) FROM stdin;
\.


--
-- Data for Name: callinglists; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.callinglists (callinglist_id, callinglist__name, callinglist_table_name, callinglist_owner_id, callinglist_comments) FROM stdin;
\.


--
-- Data for Name: calls; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.calls (call_id, company_regnumber, contact_id, contact_time, result, notes, call_type_id) FROM stdin;
\.


--
-- Data for Name: companies; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.companies (company_id, company_name, company_status_id, company_type, company_email, company_phone, company_address, company_zip, company_city, company_county, company_date_registered, company_manager, branch_code, branch_text, last_contacted, contact_again, currency_id, company_comments, reg_date, sales_rep_id, calling_list_id, company_web) FROM stdin;
1	ITfakultetet AS	\N	AS	admin@itfakultetet.no	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	2021-11-29 02:05:27.593651	\N	\N	web.itfakultetet.no
\.


--
-- Data for Name: company_status; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.company_status (company_status_id, company_status_name, company_status_description, company_status_icon) FROM stdin;
1	Egen	Egne selskaper	fa-folder blue
2	Kunde	Kundeselskaper	fa-folder yellow
3	Leverandør	Leverandørselskaper	fa-folder silver
4	Partner	Partnerselskaper	fa-folder beige
\.


--
-- Data for Name: contact_types; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.contact_types (contact_type_id, contact_type_name, contact_type_description) FROM stdin;
\.


--
-- Data for Name: contacts; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.contacts (contact_id, contact_type_id, contact_company_id, contact_first_name, contact_last_name, contact_position, contact_phone, contact_email, contact_address, contact_zip, contact_city, sales_rep_id, contact_comments) FROM stdin;
\.


--
-- Data for Name: currencies; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.currencies (currency_id, currency_name, currency_symbol, default_currency) FROM stdin;
\.


--
-- Data for Name: departments; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.departments (department_id, department_name, workplace_id, manager_id, super_department_id) FROM stdin;
1	Utviklingsavdelingen	1	2	\N
\.


--
-- Data for Name: document_types; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.document_types (document_type_id, document_type_name, document_type_type, document_type_icon, document_type_comments) FROM stdin;
\.


--
-- Data for Name: documents; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.documents (document_id, document_name, document_type_id, document_file_name, document_path, document_owner_id, document_comments, document_reg_date) FROM stdin;
\.


--
-- Data for Name: order_stages; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.order_stages (order_stage_id, order_stage_name, order_stage_description, order_stage_comments) FROM stdin;
\.


--
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.orders (order_id, customer_id, order_date, order_stage_id, sales_rep_id, customer_contact_id, unit_price, items, product_id, credit_days, other_terms, comments, regdate) FROM stdin;
\.


--
-- Data for Name: preferences; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.preferences (company_id, company_reg_number, company_name, company_address, company_zip, company_city, company_country, company_phone, company_email, company_internet, default_currency_id, default_credit_days, company_bank_account, company_manager_id) FROM stdin;
\.


--
-- Data for Name: product_categories; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.product_categories (product_category_id, product_category_name, product_categpry_description, product_category_owner_id, product_category_super_id, product_category_active) FROM stdin;
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.products (product_id, product_name, product_description, product_category_id, count_based, unit_price, currency_id, standard_terms, department_id, product_owner_id, active, product_number, in_stock, comments) FROM stdin;
\.


--
-- Data for Name: project_categories; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.project_categories (project_category_id, project_category_name, comments) FROM stdin;
\.


--
-- Data for Name: projects; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.projects (project_id, project_name, project_decription, project_start_date, project_end_date, project_client_id, project_owner_id, comments, project_category_id) FROM stdin;
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.roles (role_id, role_name, role_description, supervisor_rights) FROM stdin;
1	admin	Main Administrator Role	t
2	user	Regular user	t
\.


--
-- Data for Name: sales_stages; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.sales_stages (sales_stage_id, sales_stage_name, sales_stage_description, sales_stage_icon, sales_stage_comments) FROM stdin;
1	Lead	Leads er ubehandlede valg fra ringeliste eller kundeliste	fa-folder green	\N
2	Mulighet	Muligheter er valg med potensiale fra ringeliste eller kundeliste	fa-folder red	\N
3	Tapt	Tapt er tapte salg	fa-folder brown	\N
\.


--
-- Data for Name: settings; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.settings (own_company_id, chat_domain, default_currency_id, bank_name, bank_account, default_credit_days, manager_id, main_office_id) FROM stdin;
\.


--
-- Data for Name: template_categories; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.template_categories (template_category_id, template_category_name) FROM stdin;
\.


--
-- Data for Name: templates; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.templates (template_id, template_name, template_category_id, template_content, template_explanation, template_owner_id, reg_date) FROM stdin;
\.


--
-- Data for Name: titles; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.titles (title_id, title, description, manager) FROM stdin;
5	Selger	Selger av produkter eller tjenester	\N
6	Systemutvikler	Programmerer, applikasjonsutvikler	\N
7	Designer	Web + Ebok-designer	\N
8	Driftskonsulent	Konsulent i driftsavdelingen	\N
9	Senior Konsulent	Senior Konsulent i konsulentavdelingen	\N
10	Konsulent	Konsulent i konsulentavdelingen	\N
1	Avdelingsleder	Leder av en avdeling	t
2	CEO	Chief Executive Officer - adm direktør	t
3	CTO	Chief Technical Officer - teknisk direktør	t
4	COO	Chief Operations Officer - driftssjef	t
11	Prosjektleder	Leder av interne eller eksterne prosjekter	t
\.


--
-- Data for Name: user_role; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.user_role (user_id, role_id, from_date, to_date) FROM stdin;
1	1	2021-06-23	9999-01-01
2	2	2021-06-23	9999-01-01
2	1	2021-06-24	9999-01-01
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.users (user_id, username, first_name, last_name, department_id, user_email, password, enabled, start_date, end_date, phone, mobile_phone, address, zipcode, city, skills, signed_contract, contract_id, documents, supervisor_id, workplace_id, user_comments, title_id) FROM stdin;
1	admin	Site	Administrator	\N	admin@custosales.com	$2a$06$M5YRgsMraxxoCQYDBktrTeaaeqjJByHULYealWBrvl15du.S/SKri	t	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
2	terje	Terje	Berg-Hansen	\N	terje@custosales.com	$2a$06$6Bljr42EdxUb4oD1wWUsjehIrYzWCJ6lGozUJi.3Bby0hY4UBCx1a	t	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	6
\.


--
-- Data for Name: workhours; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.workhours (workhour_id, stamp_type, stamp, user_id) FROM stdin;
\.


--
-- Data for Name: workplaces; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.workplaces (workplace_id, workplace_name, workplace_address, workplace_zip, workplace_city, manager_id, workplace_description, main_office) FROM stdin;
1	Hjemmekontor	Kåsabakken 28	3804	Bø i Telemark	\N	\N	t
\.


--
-- Name: call_types_call_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.call_types_call_type_id_seq', 8, true);


--
-- Name: calling_lists_calling_list_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.calling_lists_calling_list_id_seq', 1, false);


--
-- Name: callinglists_callinglist_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.callinglists_callinglist_id_seq', 1, false);


--
-- Name: calls_call_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.calls_call_id_seq', 1, false);


--
-- Name: companies_company_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.companies_company_id_seq', 1, true);


--
-- Name: company_status_company_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.company_status_company_status_id_seq', 4, true);


--
-- Name: contact_types_contact_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.contact_types_contact_type_id_seq', 1, false);


--
-- Name: contacts_contact_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.contacts_contact_id_seq', 1, false);


--
-- Name: currencies_currency_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.currencies_currency_id_seq', 1, false);


--
-- Name: departments_department_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.departments_department_id_seq', 1, true);


--
-- Name: document_types_document_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.document_types_document_type_id_seq', 1, false);


--
-- Name: documents_document_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.documents_document_id_seq', 1, false);


--
-- Name: order_stages_order_stage_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.order_stages_order_stage_id_seq', 1, false);


--
-- Name: orders_order_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.orders_order_id_seq', 1, false);


--
-- Name: preferences_company_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.preferences_company_id_seq', 1, false);


--
-- Name: product_categories_product_category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.product_categories_product_category_id_seq', 1, false);


--
-- Name: products_product_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.products_product_id_seq', 1, false);


--
-- Name: project_categories_project_category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.project_categories_project_category_id_seq', 1, false);


--
-- Name: projects_project_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.projects_project_id_seq', 1, false);


--
-- Name: roles_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.roles_role_id_seq', 2, true);


--
-- Name: sales_stages_sales_stage_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.sales_stages_sales_stage_id_seq', 3, true);


--
-- Name: template_categories_template_category_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.template_categories_template_category_id_seq', 1, false);


--
-- Name: templates_template_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.templates_template_id_seq', 1, false);


--
-- Name: titles_title_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.titles_title_id_seq', 11, true);


--
-- Name: users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.users_user_id_seq', 2, true);


--
-- Name: workhours_workhour_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.workhours_workhour_id_seq', 1, false);


--
-- Name: workplaces_workplace_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.workplaces_workplace_id_seq', 1, true);


--
-- Name: call_types call_types_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.call_types
    ADD CONSTRAINT call_types_pkey PRIMARY KEY (call_type_id);


--
-- Name: calling_lists calling_lists_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.calling_lists
    ADD CONSTRAINT calling_lists_pkey PRIMARY KEY (calling_list_id);


--
-- Name: callinglists callinglists_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.callinglists
    ADD CONSTRAINT callinglists_pkey PRIMARY KEY (callinglist_id);


--
-- Name: calls calls_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.calls
    ADD CONSTRAINT calls_pkey PRIMARY KEY (call_id);


--
-- Name: companies companies_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_pkey PRIMARY KEY (company_id);


--
-- Name: company_status company_status_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.company_status
    ADD CONSTRAINT company_status_pkey PRIMARY KEY (company_status_id);


--
-- Name: contact_types contact_types_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.contact_types
    ADD CONSTRAINT contact_types_pkey PRIMARY KEY (contact_type_id);


--
-- Name: contacts contacts_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.contacts
    ADD CONSTRAINT contacts_pkey PRIMARY KEY (contact_id);


--
-- Name: currencies currencies_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.currencies
    ADD CONSTRAINT currencies_pkey PRIMARY KEY (currency_id);


--
-- Name: departments departments_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT departments_pkey PRIMARY KEY (department_id);


--
-- Name: document_types document_types_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.document_types
    ADD CONSTRAINT document_types_pkey PRIMARY KEY (document_type_id);


--
-- Name: documents documents_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.documents
    ADD CONSTRAINT documents_pkey PRIMARY KEY (document_id);


--
-- Name: order_stages order_stages_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.order_stages
    ADD CONSTRAINT order_stages_pkey PRIMARY KEY (order_stage_id);


--
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (order_id);


--
-- Name: preferences preferences_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.preferences
    ADD CONSTRAINT preferences_pkey PRIMARY KEY (company_id);


--
-- Name: product_categories product_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.product_categories
    ADD CONSTRAINT product_categories_pkey PRIMARY KEY (product_category_id);


--
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (product_id);


--
-- Name: project_categories project_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.project_categories
    ADD CONSTRAINT project_categories_pkey PRIMARY KEY (project_category_id);


--
-- Name: projects projects_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_pkey PRIMARY KEY (project_id);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (role_id);


--
-- Name: sales_stages sales_stages_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.sales_stages
    ADD CONSTRAINT sales_stages_pkey PRIMARY KEY (sales_stage_id);


--
-- Name: settings settings_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_pkey PRIMARY KEY (own_company_id);


--
-- Name: template_categories template_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.template_categories
    ADD CONSTRAINT template_categories_pkey PRIMARY KEY (template_category_id);


--
-- Name: templates templates_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.templates
    ADD CONSTRAINT templates_pkey PRIMARY KEY (template_id);


--
-- Name: titles titles_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.titles
    ADD CONSTRAINT titles_pkey PRIMARY KEY (title_id);


--
-- Name: user_role user_role_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.user_role
    ADD CONSTRAINT user_role_pkey PRIMARY KEY (user_id, role_id, from_date);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- Name: workhours workhours_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.workhours
    ADD CONSTRAINT workhours_pkey PRIMARY KEY (workhour_id);


--
-- Name: workplaces workplaces_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.workplaces
    ADD CONSTRAINT workplaces_pkey PRIMARY KEY (workplace_id);


--
-- Name: calling_lists calling_lists_calling_list_owner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.calling_lists
    ADD CONSTRAINT calling_lists_calling_list_owner_id_fkey FOREIGN KEY (calling_list_owner_id) REFERENCES public.users(user_id);


--
-- Name: callinglists callinglists_callinglist_owner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.callinglists
    ADD CONSTRAINT callinglists_callinglist_owner_id_fkey FOREIGN KEY (callinglist_owner_id) REFERENCES public.users(user_id);


--
-- Name: calls calls_call_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.calls
    ADD CONSTRAINT calls_call_type_id_fkey FOREIGN KEY (call_type_id) REFERENCES public.call_types(call_type_id);


--
-- Name: companies companies_calling_list_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_calling_list_id_fkey FOREIGN KEY (calling_list_id) REFERENCES public.calling_lists(calling_list_id);


--
-- Name: companies companies_company_status_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_company_status_id_fkey FOREIGN KEY (company_status_id) REFERENCES public.company_status(company_status_id);


--
-- Name: companies companies_currency_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_currency_id_fkey FOREIGN KEY (currency_id) REFERENCES public.currencies(currency_id);


--
-- Name: companies companies_sales_rep_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_sales_rep_id_fkey FOREIGN KEY (sales_rep_id) REFERENCES public.users(user_id);


--
-- Name: contacts contacts_contact_company_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.contacts
    ADD CONSTRAINT contacts_contact_company_id_fkey FOREIGN KEY (contact_company_id) REFERENCES public.companies(company_id);


--
-- Name: contacts contacts_contact_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.contacts
    ADD CONSTRAINT contacts_contact_type_id_fkey FOREIGN KEY (contact_type_id) REFERENCES public.contact_types(contact_type_id);


--
-- Name: contacts contacts_sales_rep_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.contacts
    ADD CONSTRAINT contacts_sales_rep_id_fkey FOREIGN KEY (sales_rep_id) REFERENCES public.users(user_id);


--
-- Name: documents documents_document_owner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.documents
    ADD CONSTRAINT documents_document_owner_id_fkey FOREIGN KEY (document_owner_id) REFERENCES public.users(user_id);


--
-- Name: documents documents_document_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.documents
    ADD CONSTRAINT documents_document_type_id_fkey FOREIGN KEY (document_type_id) REFERENCES public.document_types(document_type_id);


--
-- Name: departments manager_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT manager_id_fkey FOREIGN KEY (manager_id) REFERENCES public.users(user_id);


--
-- Name: orders orders_customer_contact_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_customer_contact_id_fkey FOREIGN KEY (customer_contact_id) REFERENCES public.contacts(contact_id);


--
-- Name: orders orders_customer_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_customer_id_fkey FOREIGN KEY (customer_id) REFERENCES public.companies(company_id);


--
-- Name: orders orders_order_stage_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_order_stage_id_fkey FOREIGN KEY (order_stage_id) REFERENCES public.order_stages(order_stage_id);


--
-- Name: orders orders_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(product_id);


--
-- Name: orders orders_sales_rep_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_sales_rep_id_fkey FOREIGN KEY (sales_rep_id) REFERENCES public.users(user_id);


--
-- Name: preferences preferences_company_manager_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.preferences
    ADD CONSTRAINT preferences_company_manager_id_fkey FOREIGN KEY (company_manager_id) REFERENCES public.users(user_id);


--
-- Name: preferences preferences_default_currency_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.preferences
    ADD CONSTRAINT preferences_default_currency_id_fkey FOREIGN KEY (default_currency_id) REFERENCES public.currencies(currency_id);


--
-- Name: product_categories product_categories_product_category_owner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.product_categories
    ADD CONSTRAINT product_categories_product_category_owner_id_fkey FOREIGN KEY (product_category_owner_id) REFERENCES public.users(user_id);


--
-- Name: product_categories product_category_super_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.product_categories
    ADD CONSTRAINT product_category_super_id_fk FOREIGN KEY (product_category_super_id) REFERENCES public.product_categories(product_category_id);


--
-- Name: products products_currency_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_currency_id_fkey FOREIGN KEY (currency_id) REFERENCES public.currencies(currency_id);


--
-- Name: products products_department_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_department_id_fkey FOREIGN KEY (department_id) REFERENCES public.departments(department_id);


--
-- Name: products products_product_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_product_category_id_fkey FOREIGN KEY (product_category_id) REFERENCES public.product_categories(product_category_id);


--
-- Name: products products_product_owner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_product_owner_id_fkey FOREIGN KEY (product_owner_id) REFERENCES public.users(user_id);


--
-- Name: projects projects_project_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_project_category_id_fkey FOREIGN KEY (project_category_id) REFERENCES public.project_categories(project_category_id);


--
-- Name: projects projects_project_client_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_project_client_id_fkey FOREIGN KEY (project_client_id) REFERENCES public.companies(company_id);


--
-- Name: projects projects_project_owner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.projects
    ADD CONSTRAINT projects_project_owner_id_fkey FOREIGN KEY (project_owner_id) REFERENCES public.users(user_id);


--
-- Name: settings settings_default_currency_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_default_currency_id_fkey FOREIGN KEY (default_currency_id) REFERENCES public.currencies(currency_id);


--
-- Name: settings settings_main_office_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_main_office_id_fkey FOREIGN KEY (main_office_id) REFERENCES public.workplaces(workplace_id);


--
-- Name: settings settings_manager_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_manager_id_fkey FOREIGN KEY (manager_id) REFERENCES public.users(user_id);


--
-- Name: settings settings_own_company_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_own_company_id_fkey FOREIGN KEY (own_company_id) REFERENCES public.companies(company_id);


--
-- Name: departments superdepartment_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT superdepartment_id_fkey FOREIGN KEY (super_department_id) REFERENCES public.departments(department_id);


--
-- Name: templates templates_template_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.templates
    ADD CONSTRAINT templates_template_category_id_fkey FOREIGN KEY (template_category_id) REFERENCES public.template_categories(template_category_id);


--
-- Name: templates templates_template_owner_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.templates
    ADD CONSTRAINT templates_template_owner_id_fkey FOREIGN KEY (template_owner_id) REFERENCES public.users(user_id);


--
-- Name: user_role user_role_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.user_role
    ADD CONSTRAINT user_role_role_id_fkey FOREIGN KEY (role_id) REFERENCES public.roles(role_id);


--
-- Name: user_role user_role_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.user_role
    ADD CONSTRAINT user_role_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id);


--
-- Name: users users_title_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_title_id_fkey FOREIGN KEY (title_id) REFERENCES public.titles(title_id);


--
-- Name: workhours workhours_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.workhours
    ADD CONSTRAINT workhours_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id);


--
-- Name: users workplace_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT workplace_id_fkey FOREIGN KEY (workplace_id) REFERENCES public.workplaces(workplace_id);


--
-- Name: departments workplace_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT workplace_id_fkey FOREIGN KEY (workplace_id) REFERENCES public.workplaces(workplace_id);


--
-- Name: workplaces workplaces_manager_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.workplaces
    ADD CONSTRAINT workplaces_manager_id_fkey FOREIGN KEY (manager_id) REFERENCES public.users(user_id);


--
-- PostgreSQL database dump complete
--

