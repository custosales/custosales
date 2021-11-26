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
-- Name: roles_role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.roles_role_id_seq', 2, true);


--
-- Name: users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: custosales
--

SELECT pg_catalog.setval('public.users_user_id_seq', 2, true);


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
-- PostgreSQL database dump complete
--

