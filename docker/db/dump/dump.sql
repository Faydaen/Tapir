CREATE TABLE public.cars (
    id SERIAL PRIMARY KEY, 
    hash text NULL, -- в данных которые мы распарсили это поле называлось id
    brand  text NULL,
    model text NULL,
    vin text NULL,
    body_type text NULL,
    engine_type text NULL,
    drive_type text NULL,
    gearbox_type text NULL,
    year integer NULL,
    price integer NULL,
    mileage integer NULL,
    owner_count integer NULL,
    is_used boolean NOT NULL,
    created_at timestamptz NOT NULL DEFAULT NOW(), -- хороший тон записывать время добавления записи
    UNIQUE(hash)  -- чтобы не записывать в базу одну и туже сущность
);

ALTER TABLE public.cars OWNER TO tapir;


