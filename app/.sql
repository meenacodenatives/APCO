--
-- PostgreSQL database dump
--

-- Dumped from database version 10.17
-- Dumped by pg_dump version 13.0

-- Started on 2021-07-21 13:24:14

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

SET default_tablespace = '';

--
-- TOC entry 241 (class 1259 OID 24856)
-- Name: user_profile; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_profile (
    id integer DEFAULT nextval('public.user_profile_id_seq'::regclass) NOT NULL,
    username character varying(1024),
    firstname character varying(1024),
    lastname character varying(1024),
    user_category integer,
    email character varying(1024),
    password character varying(1024),
    phone character varying(1024),
    country integer,
    location integer,
    dob character varying(1024),
    joining_date character varying(1024),
    gender character varying(1024),
    address character varying(1024),
    status character varying(1024),
    relieve_date character varying(1024),
    relieve_reason character varying(1024),
    secret_key character varying(1024),
    created_by character varying(1024),
    modified_by integer,
    modified_date timestamp(0) without time zone,
    is_active boolean,
    created_date timestamp(0) without time zone,
    employee_id integer,
    category character varying(1024)
);


ALTER TABLE public.user_profile OWNER TO postgres;

--
-- TOC entry 2930 (class 0 OID 24856)
-- Dependencies: 241
-- Data for Name: user_profile; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.user_profile (id, username, firstname, lastname, user_category, email, password, phone, country, location, dob, joining_date, gender, address, status, relieve_date, relieve_reason, secret_key, created_by, modified_by, modified_date, is_active, created_date, employee_id, category) FROM stdin;
1	Sinta	sinta.martin	sinta.martin	3	sinta.martin@asiatic-pco.com		9605052442	\N	3	02-05-1983	09.03.2020	Female		Active					\N	\N	t	\N	\N	
2	jayesh	jayesh.kumar	jayesh.kumar	3	jayesh.kumar@asiatic-pco.com		7306701157	\N	3	29-05-1979	01.01.2020	Male		Active					\N	\N	t	\N	\N	
3	Telson	telson.vj	telson.vj	3	telson.vj@asiatic-pco.com		7306701156	\N	3	15-05-1982	01.01.2020	Male		Active					\N	\N	t	\N	\N	
4	Thomas	thomas.mathew	thomas.mathew	3	thomas.mathew@asiatic-pco.com		7306822404	\N	2	08-05-1989	01.05.2020	Male		Active					\N	\N	t	\N	\N	
5	Vimal	vimal.v	vimal.v	3	vimal.v@asiatic-pco.com		7306701143	\N	3	29-12-1988	16.03.2020	Male		Active					\N	\N	t	\N	\N	
9	gopinathan	gopinathan	gopinathan	3	gopinathan@asiatic-pco.com		9961366999	\N	3	17-01-1963		Male		Active					\N	\N	t	\N	\N	
10	Joseph	ca.joseph	ca.joseph	3	ca.joseph@asiatic-pco.com		7306701148	\N	3	12-04-1962	01.01.2020	Male		Active					\N	\N	t	\N	\N	
11	Jyothis	jyothis.prabha	jyothis.prabha	3	jyothis.prabha@asiatic-pco.com		7306822402	\N	2	08-11-1989	01.01.2020	Male		Active					\N	\N	t	\N	\N	
12	Sundar	sundar	sundar	3	sundar@asiatic-pco.com		7306701140	\N	3	21-04-1967		Male		Active					\N	\N	t	\N	\N	
14	vel	vel	codenatives	3	vel@codenatives.com	7c4a8d09ca3762af61e59520943dc26494f8941b	989756245	91	36	2015-07-30	1993-07-22	Male	Bhell	Active	\N	\N	\N	9	\N	\N	t	2021-07-19 14:46:57	\N	\N
15	meena	meena	codenatives	2	meena@codenatives.com	7c4a8d09ca3762af61e59520943dc26494f8941b	8956795623	91	34	2007-07-20	2015-07-16	Female	Bhell Nagar	Active	\N	\N	\N	9	9	2021-07-19 14:48:33	t	2021-07-19 14:30:59	\N	\N
26	dileep	dileep.b	dileep.b	3	dileep.b@asiatic-pco.com		7306822407	\N	4	31-05-1981	15.01.2020	Male		Active					\N	\N	t	\N	\N	
13	Nithin	nithin.peter	nithin.peter	3	nithin.peter@asiatic-pco.com		7306701149	\N	3	04-11-1992	01.01.2020	Male		Active					\N	\N	t	\N	\N	
16	Padmakumar	padmakumar	padmakumar	3	padmakumar@asiatic-pco.com		7306701145	\N	6	24-01-1962		Male		Active					\N	\N	t	\N	\N	
8	corporate	corporate	corporate	3	corporate@asiatic-pco.com		8606901985	\N	7					Active					\N	\N	t	\N	\N	
17	Rex	rex.mathew	rex.mathew	3	rex.mathew@asiatic-pco.com		7306822401	\N	2	06-09-1989	06.01.2020	Male		Active					\N	\N	t	\N	\N	
18	Sandeep	sandeep.menon	sandeep.menon	3	sandeep.menon@asiatic-pco.com		9746367015	\N	3	25-05-1984	01.01.2020	Male		Active					\N	\N	t	\N	\N	
19	Shamla	shamla	shamla	3	shamla@asiatic-pco.com		8606901985	\N	3	14-05-1974		Female		Active					\N	\N	t	\N	\N	
20	Sijo	sijo.jacob	sijo.jacob	3	sijo.jacob@asiatic-pco.com		7306701150	\N	5	11-10-1983	01.01.2020	Male		Active					\N	\N	t	\N	\N	
21	akhilraj	akhilraj.ks	akhilraj.ks	3	akhilraj.ks@asiatic-pco.com		7306822409	\N	4	13-07-1989	09.03.2020	Male		Active					\N	\N	t	\N	\N	
22	anoop	anoop.rr	anoop.rr	3	anoop.rr@asiatic-pco.com		7306701151	\N	3	14-03-1982	01.01.2020	Male		Active					\N	\N	t	\N	\N	
23	arjun	arjun.chandran	arjun.chandran	3	arjun.chandran@asiatic-pco.com		7306822408	\N	4	10-06-1997	15.01.2021	Male		Active					\N	\N	t	\N	\N	
24	charley	charley.cr	charley.cr	3	charley.cr@asiatic-pco.com		7306701154	\N	3	18-04-1983	01.01.2020	Male		Active					\N	\N	t	\N	\N	
25	customercare	customercare	customercare	3	customercare@asiatic-pco.com		7306701144	\N	7					Active					\N	\N	t	\N	\N	
27	Mohandas	mohandas	mohandas	3	mohandas@asiatic-pco.com		7306701147	\N	4	02-09-1967		Male		Active					\N	\N	t	\N	\N	
6	Vinod	vinod	vinod	3	vinod@asiatic-pco.com		9388684154	\N	3	11-11-1971		Male		Active					\N	\N	t	\N	\N	
7	ajeef	ajeef.ali	ajeef.ali	3	ajeef.ali@asiatic-pco.com		7306822403	91	3	18-06-1992	01.05.2020	Male		Active					\N	\N	t	\N	\N	
\.


--
-- TOC entry 2808 (class 2606 OID 24864)
-- Name: user_profile user_profile_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_profile
    ADD CONSTRAINT user_profile_pk PRIMARY KEY (id);


-- Completed on 2021-07-21 13:24:17

--
-- PostgreSQL database dump complete
--

