--
-- PostgreSQL database dump
--

-- Dumped from database version 13.5 (Ubuntu 13.5-0ubuntu0.21.10.1)
-- Dumped by pg_dump version 13.5 (Ubuntu 13.5-0ubuntu0.21.10.1)

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
    job_title character varying(255),
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
    user_comments text
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
-- Data for Name: calls; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.calls (call_id, company_regnumber, contact_id, contact_time, result, notes, call_type_id) FROM stdin;
\.


--
-- Data for Name: contact_types; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.contact_types (contact_type_id, contact_type_name, contact_type_description) FROM stdin;
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
\.


--
-- Data for Name: preferences; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.preferences (company_id, company_reg_number, company_name, company_address, company_zip, company_city, company_country, company_phone, company_email, company_internet, default_currency_id, default_credit_days, company_bank_account, company_manager_id) FROM stdin;
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.roles (role_id, role_name, role_description, supervisor_rights) FROM stdin;
1	admin	Main Administrator Role	t
2	user	Regular user	t
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

COPY public.users (user_id, username, first_name, last_name, job_title, department_id, user_email, password, enabled, start_date, end_date, phone, mobile_phone, address, zipcode, city, skills, signed_contract, contract_id, documents, supervisor_id, workplace_id, user_comments) FROM stdin;
1	admin	Site	Administrator	\N	\N	\N	$2a$06$M5YRgsMraxxoCQYDBktrTeaaeqjJByHULYealWBrvl15du.S/SKri	t	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
2	terje	Terje	Berg-Hansen	\N	\N	\N	$2a$06$6Bljr42EdxUb4oD1wWUsjehIrYzWCJ6lGozUJi.3Bby0hY4UBCx1a	t	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: workplaces; Type: TABLE DATA; Schema: public; Owner: custosales
--

COPY public.workplaces (workplace_id, workplace_name, workplace_address, workplace_zip, workplace_city, manager_id, workplace_description, main_office) FROM stdin;
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
-- Name: calls_call_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.calls_call_id_seq', 1, false);


--
-- Name: contact_types_contact_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.contact_types_contact_type_id_seq', 1, false);


--
-- Name: currencies_currency_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.currencies_currency_id_seq', 1, false);


--
-- Name: departments_department_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.departments_department_id_seq', 1, false);


--
-- Name: preferences_company_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.preferences_company_id_seq', 1, false);


--
-- Name: roles_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.roles_role_id_seq', 2, true);


--
-- Name: users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.users_user_id_seq', 2, true);


--
-- Name: workplaces_workplace_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.workplaces_workplace_id_seq', 1, false);


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
-- Name: calls calls_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.calls
    ADD CONSTRAINT calls_pkey PRIMARY KEY (call_id);


--
-- Name: contact_types contact_types_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.contact_types
    ADD CONSTRAINT contact_types_pkey PRIMARY KEY (contact_type_id);


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
-- Name: preferences preferences_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.preferences
    ADD CONSTRAINT preferences_pkey PRIMARY KEY (company_id);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (role_id);


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
-- Name: calls calls_call_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.calls
    ADD CONSTRAINT calls_call_type_id_fkey FOREIGN KEY (call_type_id) REFERENCES public.call_types(call_type_id);


--
-- Name: departments manager_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT manager_id_fkey FOREIGN KEY (manager_id) REFERENCES public.users(user_id);


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
-- Name: departments superdepartment_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: custosales
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT superdepartment_id_fkey FOREIGN KEY (super_department_id) REFERENCES public.departments(department_id);


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

