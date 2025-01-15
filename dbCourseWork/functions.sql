-- оформление подписки

CREATE OR REPLACE FUNCTION subscribe_client_plan(client_id INT, plan_id INT, start_date DATE, finish_date DATE)
RETURNS VOID AS
$$
BEGIN
	INSERT INTO subscriber(planId, clientId, startDate, finishDate)
	VALUES (plan_id, client_id, start_date, finish_date);
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_subscribe_plans()
RETURNS TABLE (
	id integer,
	name varchar(30),
	cost smallint,
	tecniqueName varchar(20)
)AS
$$
BEGIN
	RETURN QUERY
	select plan.id, plan.name, plan.cost, technique.name from plan
	join technique on plan.techniqueId = technique.id
	where plan.active = true order by plan.id;
	END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_technique()
RETURNS TABLE (
	techniqueId integer,
	tecniqueName varchar(20)
)AS
$$
BEGIN
	RETURN QUERY
	select id, name from technique;
	END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION add_technique(client_id INT, date_d DATE, technique_id INT)
RETURNS VOID AS
$$
BEGIN
	INSERT into owner (techniqueId,clientId, buyDate) VALUES(technique_id, client_id,date_d);
END;
$$ LANGUAGE plpgsql;


--создание заказа
CREATE OR REPLACE FUNCTION get_owners(client_id INT)
RETURNS TABLE (
	techniqueId integer,
	buyDate date,
	tecniqueName varchar(20)
)AS
$$
BEGIN
	RETURN QUERY
	select technique.id, owner.buyDate, technique.name from owner
	join technique on owner.techniqueId = technique.id and owner.clientId = client_id;
	END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_masters(date DATE)
RETURNS TABLE (
	masterId integer,
	rating real
)AS
$$
DECLARE
	day smallint;
BEGIN
	day = extract(isodow from date);
	RETURN QUERY
	select master.id, master.rating from master
	join schedule on schedule.masterId = master.id and schedule.dayId = day;
	END;
$$ LANGUAGE plpgsql;



CREATE OR REPLACE FUNCTION create_order(client_id INT, technique_id INT, order_content TEXT, order_cost INT, date Date)
RETURNS VOID AS
$$
BEGIN
	INSERT INTO orders(clientId, techniqueId, content, cost, date)
	VALUES (client_id, technique_id, order_content, order_cost, date);
END;
$$ LANGUAGE plpgsql;

-- создание заказа с выбором мастера

CREATE OR REPLACE FUNCTION create_order_with_master(client_id INT, technique_id INT, order_content TEXT, order_cost INT, date1 DATE,master_id INT)
RETURNS VOID AS
$$
BEGIN
	INSERT INTO orders(clientId, techniqueId, content, cost, date)
	VALUES (client_id, technique_id, order_content, order_cost, date1);
    
	INSERT INTO masterLog(orderId, masterId)
	VALUES ((SELECT id FROM orders WHERE clientId = client_id AND techniqueId = technique_id AND date = date1), master_id);
END;
$$ LANGUAGE plpgsql;

-- просмотр статуса заказа

CREATE OR REPLACE FUNCTION get_order_status(client_id INT, technique_id INT, order_date DATE)
RETURNS VARCHAR(50) AS
$$
DECLARE
	status_name VARCHAR(50);
BEGIN
	SELECT os.name INTO status_name
	FROM orders o
	JOIN orderStatus os ON o.orderStatusId = os.id
	WHERE o.clientId = client_id AND o.techniqueId = technique_id AND o.date = order_date;

	RETURN status_name;
END;
$$ LANGUAGE plpgsql;

-- оставление отзыва

CREATE OR REPLACE FUNCTION leave_feedback(client_id INT, master_id INT, feedback_content TEXT, feedback_rating REAL)
RETURNS VOID AS
$$
DECLARE
	masterid1 integer;
BEGIN	
	SELECT masterId into masterid1 FROM masterLog
	WHERE orderId = master_id and masterStatusId = 2;	

	INSERT INTO feedback(clientId, masterId, content, rating)
	VALUES (client_id, masterid1, feedback_content, feedback_rating);
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION leave_question(client_id INT, theme_v TEXT, comment TEXT)
RETURNS VOID AS
$$
BEGIN		
	INSERT INTO supportRequest(authorId, content, theme)
	VALUES (client_id, comment, theme_v);
END;
$$ LANGUAGE plpgsql;


-- поиск ответов на частые вопросы

CREATE OR REPLACE FUNCTION search_faq(question_text TEXT)
RETURNS TEXT AS
$$
DECLARE
	answer_text TEXT;
BEGIN
	SELECT answer INTO answer_text
	FROM qa
	WHERE question = question_text;

	RETURN answer_text;
END;
$$ LANGUAGE plpgsql;

-- составление и просмотр своего расписания

CREATE OR REPLACE FUNCTION get_master_schedule(master_id INT)
RETURNS TABLE (
	day_name VARCHAR(20),
	day_short CHAR(2)
) AS $$
BEGIN
	RETURN QUERY
	SELECT day.name, day.shortName
	FROM day
	JOIN schedule ON day.id = schedule.dayId
	WHERE schedule.masterId = master_id;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_master_new_orders(master_id INT)
RETURNS TABLE (
	order_id INT,
	content TEXT,
	cost INT,
	date DATE,
	status varchar(50),
	technique varchar(50),
	client TEXT
) AS $$
BEGIN
	RETURN QUERY
	SELECT orders.id, orders.content, orders.cost, orders.date, orderStatus.name, technique.name, concat(accounts.surname,' ',accounts.name)
	FROM newOrders 
	JOIN orders ON orders.id = newOrders.orderId
	JOIN paymentType on orders.paymentTypeId = paymentType.id
	JOIN orderStatus on orders.orderStatusId = orderStatus.id
	JOIN technique on orders.techniqueId = technique.id
	JOIN client on orders.clientId = client.id
	JOIN accounts on client.userId = accounts.id
	WHERE newOrders.masterId = master_id;
END;
$$ LANGUAGE plpgsql;


-- просмотр текущих заказов

CREATE OR REPLACE FUNCTION get_master_current_orders(master_id INT)
RETURNS TABLE (
	order_id INT,
	content TEXT,
	cost INT,
	date DATE,
	status varchar(50),
	technique varchar(50),
	client TEXT

) AS $$
BEGIN
	RETURN QUERY
	SELECT orders.id, orders.content, orders.cost, orders.date, orderStatus.name, technique.name, concat(accounts.surname,' ',accounts.name)
	FROM orders
	JOIN masterLog ON orders.id = masterLog.orderId
	JOIN paymentType on orders.paymentTypeId = paymentType.id
	JOIN orderStatus on orders.orderStatusId = orderStatus.id
	JOIN technique on orders.techniqueId = technique.id
	JOIN client on orders.clientId = client.id
	JOIN accounts on client.userId = accounts.id
	WHERE masterLog.masterId = master_id AND masterLog.endDate IS NULL;
END;
$$ LANGUAGE plpgsql;

-- просмотр истории заказов

CREATE OR REPLACE FUNCTION get_master_order_history(master_id INT)
RETURNS TABLE (
	order_id INT,
	content TEXT,
	cost INT,
	date DATE,
	rating REAL,
	status varchar(50),
	technique varchar(50),
	client TEXT
) AS $$
BEGIN
	RETURN QUERY
	SELECT orders.id, orders.content, orders.cost, orders.date, feedback.rating, orderStatus.name, technique.name, concat(accounts.surname,' ',accounts.name)
	FROM orders
	JOIN masterLog ON orders.id = masterLog.orderId
	LEFT JOIN feedback ON orders.clientId = feedback.clientId
	JOIN paymentType on orders.paymentTypeId = paymentType.id
	JOIN orderStatus on orders.orderStatusId = orderStatus.id
	JOIN technique on orders.techniqueId = technique.id
	JOIN client on orders.clientId = client.id
	JOIN accounts on client.userId = accounts.id
	WHERE masterLog.masterId = master_id AND masterLog.endDate IS NOT NULL;
END;
$$ LANGUAGE plpgsql;

--прием/отклонение заказов

CREATE OR REPLACE FUNCTION accept_order(order_id INT, master_id INT)
RETURNS VOID AS $$
BEGIN
	INSERT INTO masterLog(orderId, masterId)
	VALUES (order_id, master_id);

	DELETE from newOrders where masterId = master_id and orderId=order_id;
END;
$$ LANGUAGE plpgsql;

-- Отклонить заказ мастером
CREATE OR REPLACE FUNCTION reject_order(order_id INT, master_id INT)
RETURNS VOID AS $$
BEGIN
	UPDATE masterLog
	SET masterStatusId = (SELECT id FROM masterStatus WHERE name = 'Был заменен')
	WHERE orderId = order_id AND masterId = master_id;

	DELETE from newOrders where masterId = master_id and orderId=order_id;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION finish_order(order_id INT, master_id INT)
RETURNS VOID AS $$
BEGIN
	UPDATE masterLog
	SET masterStatusId = (SELECT id FROM masterStatus WHERE name = 'Завершил заказ')
	WHERE orderId = order_id AND masterId = master_id;
END;
$$ LANGUAGE plpgsql;


--просмотр и редактирование своего профиля
CREATE OR REPLACE FUNCTION get_master(master_id INT)
RETURNS TABLE (
    userId integer,
	rating REAL,
	photo text,
	experience SMALLINT,
	qualification VARCHAR(100)
) AS $$
BEGIN
	RETURN QUERY
	SELECT master.userId, master.rating, master.photo, master.experience, master.qualification
	FROM master
	WHERE id = master_id;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_user(user_id INT)
RETURNS TABLE (
	login varchar(20),
    _name varchar(20),
    surname varchar(20),
    email varchar(30),
    phone char(11),
    password varchar(50)
) AS $$
BEGIN
RETURN QUERY
SELECT accounts.login, accounts.name, accounts.surname, accounts.email, accounts.phone, accounts.password
FROM accounts
WHERE id = user_id;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_client(client_id INT)
RETURNS TABLE (
    userId integer,
    address varchar(30),
    photo text
) AS $$
BEGIN
RETURN QUERY
SELECT client.userId, client.address, client.photo
FROM client
WHERE id = client_id;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION change_profile(master_id INT,name_ TEXT, surname_ TEXT, experience_ TEXT, qualification_ TEXT)
RETURNS VOID AS $$
BEGIN
	IF name_ IS NOT NULL THEN
	UPDATE accounts
	SET name = _name
	where id in (select userId from master where id = master_id);
	END IF;
IF surname_ IS NOT NULL THEN
	UPDATE accounts
	SET surname = surname_ 
	where id in (select userId from master where id = master_id);
	END IF;
IF experience_ IS NOT NULL THEN
	UPDATE master
	SET experience = experience_ 
	where id = master_id;
	END IF;
IF qualification_ IS NOT NULL THEN
	UPDATE master
	SET qualification = qualification_ 
	where id = master_id;
	END IF;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION create_user(login_ TEXT,password_ TEXT, name_ TEXT, surname_ TEXT, email_ TEXT, phone_ TEXT)
RETURNS RECORD AS $$
DECLARE
	ret RECORD;
BEGIN
	INSERT INTO accounts(login, password, name, surname, email, phone)
    VALUES (login_, password_, name_, surname_, email_, phone_);
    SELECT id into ret FROM accounts WHERE login = login_;
    RETURN RET;
    EXCEPTION WHEN OTHERS
    THEN RETURN RET;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION update_user(user_ INT, login_ TEXT,password_ TEXT, name_ TEXT, surname_ TEXT, email_ TEXT, phone_ TEXT)
RETURNS RECORD AS $$
DECLARE
ret RECORD;
BEGIN
UPDATE accounts
SET login = login_, password=password_, name=name_, surname=surname_, email=email_, phone=phone_
WHERE id=user_;
SELECT id into ret FROM accounts WHERE login = login_;
RETURN RET;
EXCEPTION WHEN OTHERS
    THEN RETURN RET;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION create_client(user_ INT,address_ TEXT, photo_ TEXT)
RETURNS RECORD AS $$
DECLARE
ret RECORD;
BEGIN
    INSERT INTO client(userId, address, photo)
    VALUES (user_, address_, photo_);
    SELECT id into ret FROM client WHERE userId = user_;
    RETURN RET;
    EXCEPTION WHEN OTHERS
    THEN RETURN RET;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION update_client(id_ INT, user_ INT,address_ TEXT, photo_ TEXT)
RETURNS RECORD AS $$
DECLARE
ret RECORD;
BEGIN
UPDATE client
SET userId=user_, address=address_, photo=photo_
WHERE id=id_;
SELECT id into ret FROM client WHERE userId = user_;
RETURN RET;
EXCEPTION WHEN OTHERS
    THEN RETURN RET;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION create_master(user_ INT,experience_ smallint, photo_ TEXT, rating_ real, qualification_ TEXT)
RETURNS RECORD AS $$
DECLARE
ret RECORD;
BEGIN
INSERT INTO master(userId, rating, photo, experience, qualification)
VALUES (user_, rating_, photo_, experience_, qualification_);
SELECT id into ret FROM master WHERE userId = user_;
RETURN RET;
EXCEPTION WHEN OTHERS
    THEN RETURN RET;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION update_master(id_ INT, user_ INT,experience_ smallint, photo_ TEXT, rating_ real, qualification_ TEXT)
RETURNS RECORD AS $$
DECLARE
ret RECORD;
BEGIN
UPDATE master
SET userId=user_, rating=rating_, photo=photo_, experience=experience_, qualification=qualification_
WHERE id=id_;
SELECT id into ret FROM master WHERE userId = user_;
RETURN RET;
EXCEPTION WHEN OTHERS
    THEN RETURN RET;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION check_password(
    in_username VARCHAR(255),
    in_password VARCHAR(255)
) RETURNS RECORD AS $$
DECLARE
    hashed_password VARCHAR(255);
	ret RECORD;
BEGIN
    -- Получаем хэшированный пароль для данного логина
    SELECT id into ret
    FROM accounts
    WHERE login = in_username and password = in_password;
RETURN RET;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION check_client(
    in_user integer
) RETURNS RECORD AS $$
DECLARE
	ret RECORD;
BEGIN
    SELECT id into ret
    FROM client
    WHERE userId = in_user;
RETURN RET;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION check_master(
    in_user integer
) RETURNS RECORD AS $$
DECLARE
ret RECORD;
BEGIN
SELECT id into ret
FROM master
WHERE userId = in_user;
RETURN RET;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_client_current_orders(client_id INT)
RETURNS TABLE (
	order_id INT,
	content TEXT,
	payment varchar(50),
	date DATE,
	status varchar(50),
	master TEXT,
	technique varchar(20)
) AS $$
BEGIN
	RETURN QUERY
	SELECT orders.id, orders.content, paymentType.name, orders.date, orderStatus.name, concat(accounts.name,' ', accounts.surname), technique.name
	FROM orders
	JOIN paymentType on orders.paymentTypeId = paymentType.id
	JOIN orderStatus on orders.orderStatusId = orderStatus.id
	JOIN technique on orders.techniqueId = technique.id
	LEFT JOIN masterLog on orders.id = masterLog.orderId and masterLog.masterStatusId = 1
	LEFT JOIN master on masterLog.masterId = master.id
	LEFT JOIN accounts on master.userId = accounts.id
	WHERE orders.clientId = client_id and orders.orderstatusId < 3;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION get_client_history_orders(client_id INT)
RETURNS TABLE (
	order_id INT,
	content TEXT,
	payment varchar(50),
	date DATE,
	status varchar(50),
	master TEXT,
	technique varchar(20)
) AS $$
BEGIN
	RETURN QUERY
	SELECT orders.id, orders.content, paymentType.name, orders.date, orderStatus.name, concat(accounts.name,' ', accounts.surname), technique.name
	FROM orders
	JOIN paymentType on orders.paymentTypeId = paymentType.id
	JOIN orderStatus on orders.orderStatusId = orderStatus.id
	JOIN technique on orders.techniqueId = technique.id
	LEFT JOIN masterLog on orders.id = masterLog.orderId and masterLog.masterStatusId = 2
	LEFT JOIN master on masterLog.masterId = master.id
	LEFT JOIN accounts on master.userId = accounts.id
	WHERE orders.clientId = client_id and orders.orderstatusId > 2;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION add_order(order_id INT, master_id INT)
RETURNS VOID AS $$
BEGIN
	INSERT into newOrders (orderId, masterId) values (order_id, master_id);	
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION cancel_order(order_id INT)
RETURNS VOID AS $$
BEGIN
	UPDATE orders
	SET orderStatusId = 4
	WHERE id = order_id;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION findall_faq()
RETURNS TABLE(
  question1 TEXT,
  answer1 TEXT)AS
$$
BEGIN
  RETURN QUERY
  SELECT question, answer from qa;
  END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION findall_subscribes(client_id INT)
RETURNS TABLE (
  sub_type varchar(30),
  sub_start_date date,
  sub_finish_date date,
  sub_price smallint
)AS
$$
BEGIN
  RETURN QUERY
  select plan.name, subscriber.startDate, subscriber.finishDate, plan.cost from subscriber
  join plan on  plan.id=subscriber.planId
  where client_id=subscriber.clientId;
  END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION findall_workers()
RETURNS TABLE (
  w_photo text,
  w_name TEXT,
  w_rating real,
  w_experience smallint,
  w_id int,
  w_qualification varchar(100)
)AS
$$
BEGIN
  RETURN QUERY
  select master.photo, concat(accounts.name,' ', accounts.surname), master.rating, master.experience, master.id, master.qualification from master
  join accounts on  accounts.id=master.userId;
  END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION delete_schedule(master_id INT)
RETURNS VOID AS
$$
BEGIN
	DELETE from schedule where masterId = master_id; 
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION add_day(master_id INT, day_id INT)
RETURNS VOID AS
$$
BEGIN
	INSERT into schedule (masterId, dayId) VALUES (master_id, day_id);
END;
$$ LANGUAGE plpgsql;




