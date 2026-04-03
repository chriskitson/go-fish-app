-- UK Countries (administrative_area_level_1)
INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'England', 'administrative_area_level_1', 'England', '/images/locations/england.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'England' AND `key` = 'administrative_area_level_1');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Northern Ireland', 'administrative_area_level_1', 'Northern Ireland', '/images/locations/northern-ireland.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Northern Ireland' AND `key` = 'administrative_area_level_1');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Scotland', 'administrative_area_level_1', 'Scotland', '/images/locations/scotland.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Scotland' AND `key` = 'administrative_area_level_1');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Wales', 'administrative_area_level_1', 'Wales', '/images/locations/wales.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Wales' AND `key` = 'administrative_area_level_1');

-- England: Ceremonial Counties (administrative_area_level_2)
INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Bedfordshire', 'administrative_area_level_2', 'Bedfordshire', '/images/locations/bedfordshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Bedfordshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Berkshire', 'administrative_area_level_2', 'Berkshire', '/images/locations/berkshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Berkshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Bristol', 'administrative_area_level_2', 'Bristol', '/images/locations/bristol.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Bristol' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Buckinghamshire', 'administrative_area_level_2', 'Buckinghamshire', '/images/locations/buckinghamshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Buckinghamshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Cambridgeshire', 'administrative_area_level_2', 'Cambridgeshire', '/images/locations/cambridgeshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Cambridgeshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Cheshire', 'administrative_area_level_2', 'Cheshire', '/images/locations/cheshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Cheshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'City of London', 'administrative_area_level_2', 'City of London', '/images/locations/city-of-london.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'City of London' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Cornwall', 'administrative_area_level_2', 'Cornwall', '/images/locations/cornwall.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Cornwall' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Cumbria', 'administrative_area_level_2', 'Cumbria', '/images/locations/cumbria.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Cumbria' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Derbyshire', 'administrative_area_level_2', 'Derbyshire', '/images/locations/derbyshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Derbyshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Devon', 'administrative_area_level_2', 'Devon', '/images/locations/devon.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Devon' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Dorset', 'administrative_area_level_2', 'Dorset', '/images/locations/dorset.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Dorset' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Durham', 'administrative_area_level_2', 'Durham', '/images/locations/durham.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Durham' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'East Riding of Yorkshire', 'administrative_area_level_2', 'East Riding of Yorkshire', '/images/locations/east-riding-of-yorkshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'East Riding of Yorkshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'East Sussex', 'administrative_area_level_2', 'East Sussex', '/images/locations/east-sussex.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'East Sussex' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Essex', 'administrative_area_level_2', 'Essex', '/images/locations/essex.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Essex' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Gloucestershire', 'administrative_area_level_2', 'Gloucestershire', '/images/locations/gloucestershire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Gloucestershire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Greater London', 'administrative_area_level_2', 'Greater London', '/images/locations/greater-london.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Greater London' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Greater Manchester', 'administrative_area_level_2', 'Greater Manchester', '/images/locations/greater-manchester.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Greater Manchester' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Hampshire', 'administrative_area_level_2', 'Hampshire', '/images/locations/hampshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Hampshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Herefordshire', 'administrative_area_level_2', 'Herefordshire', '/images/locations/herefordshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Herefordshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Hertfordshire', 'administrative_area_level_2', 'Hertfordshire', '/images/locations/hertfordshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Hertfordshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Isle of Wight', 'administrative_area_level_2', 'Isle of Wight', '/images/locations/isle-of-wight.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Isle of Wight' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Kent', 'administrative_area_level_2', 'Kent', '/images/locations/kent.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Kent' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Lancashire', 'administrative_area_level_2', 'Lancashire', '/images/locations/lancashire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Lancashire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Leicestershire', 'administrative_area_level_2', 'Leicestershire', '/images/locations/leicestershire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Leicestershire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Lincolnshire', 'administrative_area_level_2', 'Lincolnshire', '/images/locations/lincolnshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Lincolnshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Merseyside', 'administrative_area_level_2', 'Merseyside', '/images/locations/merseyside.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Merseyside' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Norfolk', 'administrative_area_level_2', 'Norfolk', '/images/locations/norfolk.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Norfolk' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'North Yorkshire', 'administrative_area_level_2', 'North Yorkshire', '/images/locations/north-yorkshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'North Yorkshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Northamptonshire', 'administrative_area_level_2', 'Northamptonshire', '/images/locations/northamptonshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Northamptonshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Northumberland', 'administrative_area_level_2', 'Northumberland', '/images/locations/northumberland.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Northumberland' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Nottinghamshire', 'administrative_area_level_2', 'Nottinghamshire', '/images/locations/nottinghamshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Nottinghamshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Oxfordshire', 'administrative_area_level_2', 'Oxfordshire', '/images/locations/oxfordshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Oxfordshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Rutland', 'administrative_area_level_2', 'Rutland', '/images/locations/rutland.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Rutland' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Shropshire', 'administrative_area_level_2', 'Shropshire', '/images/locations/shropshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Shropshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Somerset', 'administrative_area_level_2', 'Somerset', '/images/locations/somerset.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Somerset' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'South Yorkshire', 'administrative_area_level_2', 'South Yorkshire', '/images/locations/south-yorkshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'South Yorkshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Staffordshire', 'administrative_area_level_2', 'Staffordshire', '/images/locations/staffordshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Staffordshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Suffolk', 'administrative_area_level_2', 'Suffolk', '/images/locations/suffolk.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Suffolk' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Surrey', 'administrative_area_level_2', 'Surrey', '/images/locations/surrey.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Surrey' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Tyne and Wear', 'administrative_area_level_2', 'Tyne and Wear', '/images/locations/tyne-and-wear.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Tyne and Wear' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Warwickshire', 'administrative_area_level_2', 'Warwickshire', '/images/locations/warwickshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Warwickshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'West Midlands', 'administrative_area_level_2', 'West Midlands', '/images/locations/west-midlands.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'West Midlands' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'West Sussex', 'administrative_area_level_2', 'West Sussex', '/images/locations/west-sussex.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'West Sussex' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'West Yorkshire', 'administrative_area_level_2', 'West Yorkshire', '/images/locations/west-yorkshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'West Yorkshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Wiltshire', 'administrative_area_level_2', 'Wiltshire', '/images/locations/wiltshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Wiltshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Worcestershire', 'administrative_area_level_2', 'Worcestershire', '/images/locations/worcestershire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Worcestershire' AND `key` = 'administrative_area_level_2');

-- Northern Ireland: Local Government Districts (administrative_area_level_2)
INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Antrim and Newtownabbey', 'administrative_area_level_2', 'Antrim and Newtownabbey', '/images/locations/antrim-and-newtownabbey.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Antrim and Newtownabbey' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Ards and North Down', 'administrative_area_level_2', 'Ards and North Down', '/images/locations/ards-and-north-down.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Ards and North Down' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Armagh City, Banbridge and Craigavon', 'administrative_area_level_2', 'Armagh City, Banbridge and Craigavon', '/images/locations/armagh-city-banbridge-and-craigavon.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Armagh City, Banbridge and Craigavon' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Belfast City', 'administrative_area_level_2', 'Belfast City', '/images/locations/belfast-city.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Belfast City' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Causeway Coast and Glens', 'administrative_area_level_2', 'Causeway Coast and Glens', '/images/locations/causeway-coast-and-glens.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Causeway Coast and Glens' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Derry City and Strabane', 'administrative_area_level_2', 'Derry City and Strabane', '/images/locations/derry-city-and-strabane.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Derry City and Strabane' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Fermanagh and Omagh', 'administrative_area_level_2', 'Fermanagh and Omagh', '/images/locations/fermanagh-and-omagh.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Fermanagh and Omagh' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Lisburn and Castlereagh', 'administrative_area_level_2', 'Lisburn and Castlereagh', '/images/locations/lisburn-and-castlereagh.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Lisburn and Castlereagh' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Mid and East Antrim', 'administrative_area_level_2', 'Mid and East Antrim', '/images/locations/mid-and-east-antrim.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Mid and East Antrim' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Mid Ulster', 'administrative_area_level_2', 'Mid Ulster', '/images/locations/mid-ulster.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Mid Ulster' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Newry, Mourne and Down', 'administrative_area_level_2', 'Newry, Mourne and Down', '/images/locations/newry-mourne-and-down.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Newry, Mourne and Down' AND `key` = 'administrative_area_level_2');

-- Scotland: Council Areas (administrative_area_level_2)
INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Aberdeen City', 'administrative_area_level_2', 'Aberdeen City', '/images/locations/aberdeen-city.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Aberdeen City' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Aberdeenshire', 'administrative_area_level_2', 'Aberdeenshire', '/images/locations/aberdeenshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Aberdeenshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Angus', 'administrative_area_level_2', 'Angus', '/images/locations/angus.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Angus' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Argyll and Bute', 'administrative_area_level_2', 'Argyll and Bute', '/images/locations/argyll-and-bute.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Argyll and Bute' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'City of Edinburgh', 'administrative_area_level_2', 'City of Edinburgh', '/images/locations/city-of-edinburgh.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'City of Edinburgh' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Clackmannanshire', 'administrative_area_level_2', 'Clackmannanshire', '/images/locations/clackmannanshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Clackmannanshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Dumfries and Galloway', 'administrative_area_level_2', 'Dumfries and Galloway', '/images/locations/dumfries-and-galloway.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Dumfries and Galloway' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Dundee City', 'administrative_area_level_2', 'Dundee City', '/images/locations/dundee-city.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Dundee City' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'East Ayrshire', 'administrative_area_level_2', 'East Ayrshire', '/images/locations/east-ayrshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'East Ayrshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'East Dunbartonshire', 'administrative_area_level_2', 'East Dunbartonshire', '/images/locations/east-dunbartonshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'East Dunbartonshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'East Lothian', 'administrative_area_level_2', 'East Lothian', '/images/locations/east-lothian.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'East Lothian' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'East Renfrewshire', 'administrative_area_level_2', 'East Renfrewshire', '/images/locations/east-renfrewshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'East Renfrewshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Falkirk', 'administrative_area_level_2', 'Falkirk', '/images/locations/falkirk.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Falkirk' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Fife', 'administrative_area_level_2', 'Fife', '/images/locations/fife.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Fife' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Glasgow City', 'administrative_area_level_2', 'Glasgow City', '/images/locations/glasgow-city.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Glasgow City' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Highland', 'administrative_area_level_2', 'Highland', '/images/locations/highland.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Highland' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Inverclyde', 'administrative_area_level_2', 'Inverclyde', '/images/locations/inverclyde.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Inverclyde' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Midlothian', 'administrative_area_level_2', 'Midlothian', '/images/locations/midlothian.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Midlothian' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Moray', 'administrative_area_level_2', 'Moray', '/images/locations/moray.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Moray' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Na h-Eileanan Siar', 'administrative_area_level_2', 'Na h-Eileanan Siar', '/images/locations/na-h-eileanan-siar.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Na h-Eileanan Siar' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'North Ayrshire', 'administrative_area_level_2', 'North Ayrshire', '/images/locations/north-ayrshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'North Ayrshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'North Lanarkshire', 'administrative_area_level_2', 'North Lanarkshire', '/images/locations/north-lanarkshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'North Lanarkshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Orkney Islands', 'administrative_area_level_2', 'Orkney Islands', '/images/locations/orkney-islands.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Orkney Islands' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Perth and Kinross', 'administrative_area_level_2', 'Perth and Kinross', '/images/locations/perth-and-kinross.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Perth and Kinross' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Renfrewshire', 'administrative_area_level_2', 'Renfrewshire', '/images/locations/renfrewshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Renfrewshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Scottish Borders', 'administrative_area_level_2', 'Scottish Borders', '/images/locations/scottish-borders.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Scottish Borders' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Shetland Islands', 'administrative_area_level_2', 'Shetland Islands', '/images/locations/shetland-islands.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Shetland Islands' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'South Ayrshire', 'administrative_area_level_2', 'South Ayrshire', '/images/locations/south-ayrshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'South Ayrshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'South Lanarkshire', 'administrative_area_level_2', 'South Lanarkshire', '/images/locations/south-lanarkshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'South Lanarkshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Stirling', 'administrative_area_level_2', 'Stirling', '/images/locations/stirling.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Stirling' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'West Dunbartonshire', 'administrative_area_level_2', 'West Dunbartonshire', '/images/locations/west-dunbartonshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'West Dunbartonshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'West Lothian', 'administrative_area_level_2', 'West Lothian', '/images/locations/west-lothian.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'West Lothian' AND `key` = 'administrative_area_level_2');

-- Wales: Principal Areas (administrative_area_level_2)
INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Blaenau Gwent', 'administrative_area_level_2', 'Blaenau Gwent', '/images/locations/blaenau-gwent.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Blaenau Gwent' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Bridgend', 'administrative_area_level_2', 'Bridgend', '/images/locations/bridgend.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Bridgend' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Caerphilly', 'administrative_area_level_2', 'Caerphilly', '/images/locations/caerphilly.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Caerphilly' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Cardiff', 'administrative_area_level_2', 'Cardiff', '/images/locations/cardiff.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Cardiff' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Carmarthenshire', 'administrative_area_level_2', 'Carmarthenshire', '/images/locations/carmarthenshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Carmarthenshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Ceredigion', 'administrative_area_level_2', 'Ceredigion', '/images/locations/ceredigion.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Ceredigion' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Conwy', 'administrative_area_level_2', 'Conwy', '/images/locations/conwy.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Conwy' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Denbighshire', 'administrative_area_level_2', 'Denbighshire', '/images/locations/denbighshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Denbighshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Flintshire', 'administrative_area_level_2', 'Flintshire', '/images/locations/flintshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Flintshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Gwynedd', 'administrative_area_level_2', 'Gwynedd', '/images/locations/gwynedd.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Gwynedd' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Isle of Anglesey', 'administrative_area_level_2', 'Isle of Anglesey', '/images/locations/isle-of-anglesey.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Isle of Anglesey' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Merthyr Tydfil', 'administrative_area_level_2', 'Merthyr Tydfil', '/images/locations/merthyr-tydfil.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Merthyr Tydfil' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Monmouthshire', 'administrative_area_level_2', 'Monmouthshire', '/images/locations/monmouthshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Monmouthshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Neath Port Talbot', 'administrative_area_level_2', 'Neath Port Talbot', '/images/locations/neath-port-talbot.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Neath Port Talbot' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Newport', 'administrative_area_level_2', 'Newport', '/images/locations/newport.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Newport' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Pembrokeshire', 'administrative_area_level_2', 'Pembrokeshire', '/images/locations/pembrokeshire.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Pembrokeshire' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Powys', 'administrative_area_level_2', 'Powys', '/images/locations/powys.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Powys' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Rhondda Cynon Taf', 'administrative_area_level_2', 'Rhondda Cynon Taf', '/images/locations/rhondda-cynon-taf.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Rhondda Cynon Taf' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Swansea', 'administrative_area_level_2', 'Swansea', '/images/locations/swansea.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Swansea' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Torfaen', 'administrative_area_level_2', 'Torfaen', '/images/locations/torfaen.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Torfaen' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Vale of Glamorgan', 'administrative_area_level_2', 'Vale of Glamorgan', '/images/locations/vale-of-glamorgan.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Vale of Glamorgan' AND `key` = 'administrative_area_level_2');

INSERT INTO `categories` (`name`, `key`, `value`, `image`)
SELECT 'Wrexham', 'administrative_area_level_2', 'Wrexham', '/images/locations/wrexham.png'
WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `name` = 'Wrexham' AND `key` = 'administrative_area_level_2');