<?php

namespace Grocy\Services;

use \Grocy\Services\LocalizationService;

class DemoDataGeneratorService extends BaseService
{
	public function __construct()
	{
		parent::__construct();
		$this->LocalizationService = new LocalizationService(GROCY_CULTURE);
	}

	protected $LocalizationService;

	public function PopulateDemoData()
	{
		$rowCount = $this->DatabaseService->ExecuteDbQuery('SELECT COUNT(*) FROM migrations WHERE migration = -1')->fetchColumn();
		if (intval($rowCount) === 0)
		{
			$loremIpsum = 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.';
			$loremIpsumWithHtmlFormattings = "<h1>Lorem ipsum</h1><p>Lorem ipsum <b>dolor sit</b> amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur <span style=\"background-color: rgb(255, 255, 0);\">sadipscing elitr</span>, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p><ul><li>At vero eos et accusam et justo duo dolores et ea rebum.</li><li>Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</li></ul><h1>Lorem ipsum</h1><p>Lorem ipsum <b>dolor sit</b> amet, consetetur \r\nsadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et \r\ndolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et\r\n justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea \r\ntakimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit \r\namet, consetetur <span style=\"background-color: rgb(255, 255, 0);\">sadipscing elitr</span>,\r\n sed diam nonumy eirmod tempor invidunt ut labore et dolore magna \r\naliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo \r\ndolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus \r\nest Lorem ipsum dolor sit amet.</p>";

			$sql = "
				UPDATE users SET username = '{$this->__t_sql('Demo User')}' WHERE id = 1;
				INSERT INTO users (username, password) VALUES ('{$this->__t_sql('Demo User')} 2', 'x');
				INSERT INTO users (username, password) VALUES ('{$this->__t_sql('Demo User')} 3', 'x');
				INSERT INTO users (username, password) VALUES ('{$this->__t_sql('Demo User')} 4', 'x');

				INSERT INTO locations (name) VALUES ('{$this->__t_sql('Pantry')}'); --3
				INSERT INTO locations (name) VALUES ('{$this->__t_sql('Candy cupboard')}'); --4
				INSERT INTO locations (name) VALUES ('{$this->__t_sql('Tinned food cupboard')}'); --5

				INSERT INTO quantity_units (name, name_plural) VALUES ('{$this->__n_sql(1, 'Glass', 'Glasses')}', '{$this->__n_sql(2, 'Glass', 'Glasses')}'); --4
				INSERT INTO quantity_units (name, name_plural) VALUES ('{$this->__n_sql(1, 'Tin', 'Tins')}', '{$this->__n_sql(2, 'Tin', 'Tins')}'); --5
				INSERT INTO quantity_units (name, name_plural) VALUES ('{$this->__n_sql(1, 'Can', 'Cans')}', '{$this->__n_sql(2, 'Can', 'Cans')}'); --6
				INSERT INTO quantity_units (name, name_plural) VALUES ('{$this->__n_sql(1, 'Bunch', 'Bunches')}', '{$this->__n_sql(2, 'Bunch', 'Bunches')}'); --7
				INSERT INTO quantity_units (name, name_plural) VALUES ('{$this->__n_sql(1, 'Gram', 'Grams')}', '{$this->__n_sql(2, 'Gram', 'Grams')}'); --8
				INSERT INTO quantity_units (name, name_plural) VALUES ('{$this->__n_sql(1, 'Liter', 'Liters')}', '{$this->__n_sql(2, 'Liter', 'Liters')}'); --9
				INSERT INTO quantity_units (name, name_plural) VALUES ('{$this->__n_sql(1, 'Bottle', 'Bottles')}', '{$this->__n_sql(2, 'Bottle', 'Bottles')}'); --10
				INSERT INTO quantity_units (name, name_plural) VALUES ('{$this->__n_sql(1, 'Milliliter', 'Milliliters')}', '{$this->__n_sql(2, 'Milliliter', 'Milliliters')}'); --11

				INSERT INTO product_groups(name) VALUES ('01 {$this->__t_sql('Sweets')}'); --1
				INSERT INTO product_groups(name) VALUES ('02 {$this->__t_sql('Bakery products')}'); --2
				INSERT INTO product_groups(name) VALUES ('03 {$this->__t_sql('Tinned food')}'); --3
				INSERT INTO product_groups(name) VALUES ('04 {$this->__t_sql('Butchery products')}'); --4
				INSERT INTO product_groups(name) VALUES ('05 {$this->__t_sql('Vegetables/Fruits')}'); --5
				INSERT INTO product_groups(name) VALUES ('06 {$this->__t_sql('Refrigerated products')}'); --6

				DELETE FROM sqlite_sequence WHERE name = 'products'; --Just to keep IDs in order as mentioned here...
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, min_stock_amount, product_group_id, picture_file_name) VALUES ('{$this->__t_sql('Cookies')}', 4, 3, 3, 1, 8, 1, 'cookies.jpg'); --1
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, min_stock_amount, product_group_id) VALUES ('{$this->__t_sql('Chocolate')}', 4, 3, 3, 1, 8, 1); --2
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, min_stock_amount, product_group_id, picture_file_name) VALUES ('{$this->__t_sql('Gummy bears')}', 4, 3, 3, 1, 8, 1, 'gummybears.jpg'); --3
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, min_stock_amount, product_group_id) VALUES ('{$this->__t_sql('Crisps')}', 4, 3, 3, 1, 10, 1); --4
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Eggs')}', 2, 3, 2, 10, 5); --5
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Noodles')}', 3, 3, 3, 1, 6); --6
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Pickles')}', 5, 4, 4, 1, 3); --7
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Gulash soup')}', 5, 5, 5, 1, 3); --8
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Yogurt')}', 2, 6, 6, 1, 6); --9
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Cheese')}', 2, 3, 3, 1, 6); --10
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id, description) VALUES ('{$this->__t_sql('Cold cuts')}', 2, 3, 3, 1, 6, '{$loremIpsum}'); --11
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id, picture_file_name, default_best_before_days) VALUES ('{$this->__t_sql('Paprika')}', 2, 2, 2, 1, 5, 'paprika.jpg', 7); --12
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id, picture_file_name, default_best_before_days) VALUES ('{$this->__t_sql('Cucumber')}', 2, 2, 2, 1, 5, 'cucumber.jpg', 7); --13
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id, default_best_before_days) VALUES ('{$this->__t_sql('Radish')}', 2, 7, 7, 1, 5, 7); --14
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id, picture_file_name, default_best_before_days) VALUES ('{$this->__t_sql('Tomato')}', 2, 2, 2, 1, 5, 'tomato.jpg', 7); --15
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Pizza dough')}', 2, 3, 3, 1, 6); --16
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Sieved tomatoes')}', 5, 5, 5, 1, 3); --17
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Salami')}', 2, 3, 3, 1, 6); --18
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Toast')}', 3, 5, 5, 1, 2); --19
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Minced meat')}', 2, 3, 3, 1, 4); --20
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id, enable_tare_weight_handling, tare_weight) VALUES ('{$this->__t_sql('Flour')}', 3, 8, 8, 1, 3, 1, 500); --21
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Sugar')}', 3, 3, 3, 1, 3); --22
				INSERT INTO products (name, location_id, qu_id_purchase, qu_id_stock, qu_factor_purchase_to_stock, product_group_id) VALUES ('{$this->__t_sql('Milk')}', 2, 10, 10, 1, 6); --23

				INSERT INTO shopping_list (note, amount) VALUES ('{$this->__t_sql('Some good snacks')}', 1);
				INSERT INTO shopping_list (product_id, amount) VALUES (20, 1);
				INSERT INTO shopping_list (product_id, amount) VALUES (17, 1);

				INSERT INTO recipes (name, description, picture_file_name) VALUES ('{$this->__t_sql('Pizza')}', '{$loremIpsumWithHtmlFormattings}', 'pizza.jpg'); --1
				INSERT INTO recipes (name, description, picture_file_name) VALUES ('{$this->__t_sql('Spaghetti bolognese')}', '{$loremIpsumWithHtmlFormattings}', 'spaghetti.jpg'); --2
				INSERT INTO recipes (name, description, picture_file_name) VALUES ('{$this->__t_sql('Sandwiches')}', '{$loremIpsumWithHtmlFormattings}', 'sandwiches.jpg'); --3
				INSERT INTO recipes (name, description, picture_file_name) VALUES ('{$this->__t_sql('Pancakes')}', '{$loremIpsumWithHtmlFormattings}', 'pancakes.jpg'); --4
				INSERT INTO recipes (name, description, picture_file_name) VALUES ('{$this->__t_sql('Chocolate sauce')}', '{$loremIpsumWithHtmlFormattings}', 'chocolate_sauce.jpg'); --5
				INSERT INTO recipes (name, description, picture_file_name) VALUES ('{$this->__t_sql('Pancakes')} / {$this->__t_sql('Chocolate sauce')}', '{$loremIpsumWithHtmlFormattings}', 'pancakes_chocolate_sauce.jpg'); --6

				INSERT INTO recipes_pos (recipe_id, product_id, amount, ingredient_group) VALUES (1, 16, 1, '{$this->__t_sql('Bottom')}');
				INSERT INTO recipes_pos (recipe_id, product_id, amount, ingredient_group) VALUES (1, 17, 1, '{$this->__t_sql('Topping')}');
				INSERT INTO recipes_pos (recipe_id, product_id, amount, note, ingredient_group) VALUES (1, 18, 1, '{$this->__t_sql('This is the note content of the recipe ingredient')}', '{$this->__t_sql('Topping')}');
				INSERT INTO recipes_pos (recipe_id, product_id, amount, ingredient_group) VALUES (1, 10, 1, '{$this->__t_sql('Bottom')}');
				INSERT INTO recipes_pos (recipe_id, product_id, amount) VALUES (2, 6, 1);
				INSERT INTO recipes_pos (recipe_id, product_id, amount) VALUES (2, 10, 1);
				INSERT INTO recipes_pos (recipe_id, product_id, amount, note) VALUES (2, 17, 1, '{$this->__t_sql('This is the note content of the recipe ingredient')}');
				INSERT INTO recipes_pos (recipe_id, product_id, amount) VALUES (2, 20, 1);
				INSERT INTO recipes_pos (recipe_id, product_id, amount) VALUES (3, 10, 1);
				INSERT INTO recipes_pos (recipe_id, product_id, amount) VALUES (3, 11, 1);
				INSERT INTO recipes_pos (recipe_id, product_id, amount) VALUES (4, 5, 4);
				INSERT INTO recipes_pos (recipe_id, product_id, amount, qu_id, only_check_single_unit_in_stock) VALUES (4, 21, 200, 8, 1);
				INSERT INTO recipes_pos (recipe_id, product_id, amount, qu_id, only_check_single_unit_in_stock) VALUES (4, 22, 200, 8, 1);
				INSERT INTO recipes_pos (recipe_id, product_id, amount) VALUES (5, 2, 1);
				INSERT INTO recipes_pos (recipe_id, product_id, amount, qu_id, only_check_single_unit_in_stock) VALUES (5, 23, 200, 11, 1);

				INSERt INTO recipes_nestings(recipe_id, includes_recipe_id) VALUES (6, 4);
				INSERt INTO recipes_nestings(recipe_id, includes_recipe_id) VALUES (6, 5);

				INSERT INTO chores (name, period_type, period_days) VALUES ('{$this->__t_sql('Changed towels in the bathroom')}', 'manually', 5); --1
				INSERT INTO chores (name, period_type, period_days) VALUES ('{$this->__t_sql('Cleaned the kitchen floor')}', 'dynamic-regular', 7); --2
				INSERT INTO chores (name, period_type, period_days) VALUES ('{$this->__t_sql('Lawn mowed in the garden')}', 'dynamic-regular', 21); --3
				INSERT INTO chores (name, period_type, period_days) VALUES ('{$this->__t_sql('The thing which happens on the 5th of every month')}', 'monthly', 5); --4
				INSERT INTO chores (name, period_type) VALUES ('{$this->__t_sql('The thing which happens daily')}', 'daily'); --5
				INSERT INTO chores (name, period_type, period_config) VALUES ('{$this->__t_sql('The thing which happens on Mondays and Wednesdays')}', 'weekly', 'monday,wednesday'); --6

				INSERT INTO batteries (name, description, used_in) VALUES ('{$this->__t_sql('Battery')}1', '{$this->__t_sql('Warranty ends')} 2023', '{$this->__t_sql('TV remote control')}'); --1
				INSERT INTO batteries (name, description, used_in) VALUES ('{$this->__t_sql('Battery')}2', '{$this->__t_sql('Warranty ends')} 2022', '{$this->__t_sql('Alarm clock')}'); --2
				INSERT INTO batteries (name, description, used_in, charge_interval_days) VALUES ('{$this->__t_sql('Battery')}3', '{$this->__t_sql('Warranty ends')} 2022', '{$this->__t_sql('Heat remote control')}', 60); --3
				INSERT INTO batteries (name, description, used_in, charge_interval_days) VALUES ('{$this->__t_sql('Battery')}4', '{$this->__t_sql('Warranty ends')} 2028', '{$this->__t_sql('Heat remote control')}', 60); --4

				INSERT INTO task_categories (name) VALUES ('{$this->__t_sql('Home')}'); --1
				INSERT INTO task_categories (name) VALUES ('{$this->__t_sql('Life')}'); --2
				INSERT INTO task_categories (name) VALUES ('{$this->__t_sql('Projects')}'); --3

				INSERT INTO tasks (name, category_id, due_date, assigned_to_user_id) VALUES ('{$this->__t_sql('Repair the garage door')}', 1, date(datetime('now', 'localtime'), '+14 day'), 1);
				INSERT INTO tasks (name, category_id, due_date, assigned_to_user_id) VALUES ('{$this->__t_sql('Fork and improve grocy')}', 3, date(datetime('now', 'localtime'), '+30 day'), 1);
				INSERT INTO tasks (name, category_id, due_date, assigned_to_user_id) VALUES ('{$this->__t_sql('Task')}1', 2, date(datetime('now', 'localtime'), '-1 day'), 1);
				INSERT INTO tasks (name, category_id, due_date, assigned_to_user_id) VALUES ('{$this->__t_sql('Task')}2', 2, date(datetime('now', 'localtime'), '-1 day'), 1);
				INSERT INTO tasks (name, due_date, assigned_to_user_id) VALUES ('{$this->__t_sql('Find a solution for what to do when I forget the door keys')}', date(datetime('now', 'localtime'), '+3 day'), 1);
				INSERT INTO tasks (name, due_date, assigned_to_user_id) VALUES ('{$this->__t_sql('Task')}3', date(datetime('now', 'localtime'), '+4 day'), 1);

				INSERT INTO equipment (name, description, instruction_manual_file_name) VALUES ('{$this->__t_sql('Coffee machine')}', '{$loremIpsumWithHtmlFormattings}', 'loremipsum.pdf'); --1
				INSERT INTO equipment (name, description) VALUES ('{$this->__t_sql('Dishwasher')}', '{$loremIpsumWithHtmlFormattings}'); --2

				INSERT INTO migrations (migration) VALUES (-1);
			";

			$this->DatabaseService->ExecuteDbStatement($sql);

			$stockService = new StockService();
			$stockService->AddProduct(3, 1, date('Y-m-d', strtotime('+180 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(3, 1, date('Y-m-d', strtotime('+180 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(3, 1, date('Y-m-d', strtotime('+180 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(3, 1, date('Y-m-d', strtotime('+180 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(3, 1, date('Y-m-d', strtotime('+180 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(4, 1, date('Y-m-d', strtotime('+180 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(4, 1, date('Y-m-d', strtotime('+180 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(4, 1, date('Y-m-d', strtotime('+180 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(4, 1, date('Y-m-d', strtotime('+180 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(4, 1, date('Y-m-d', strtotime('+180 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(5, 1, date('Y-m-d', strtotime('+20 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(5, 1, date('Y-m-d', strtotime('+20 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(5, 1, date('Y-m-d', strtotime('+20 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(5, 1, date('Y-m-d', strtotime('+20 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(5, 1, date('Y-m-d', strtotime('+20 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(6, 1, date('Y-m-d', strtotime('+600 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(6, 1, date('Y-m-d', strtotime('+600 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(6, 1, date('Y-m-d', strtotime('+600 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(6, 1, date('Y-m-d', strtotime('+600 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(6, 1, date('Y-m-d', strtotime('+600 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(7, 1, date('Y-m-d', strtotime('+800 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(7, 1, date('Y-m-d', strtotime('+800 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(7, 1, date('Y-m-d', strtotime('+800 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(7, 1, date('Y-m-d', strtotime('+800 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(7, 1, date('Y-m-d', strtotime('+800 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(8, 1, date('Y-m-d', strtotime('+900 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(8, 1, date('Y-m-d', strtotime('+900 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(8, 1, date('Y-m-d', strtotime('+900 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(8, 1, date('Y-m-d', strtotime('+900 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(8, 1, date('Y-m-d', strtotime('+900 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(9, 1, date('Y-m-d', strtotime('+14 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(9, 1, date('Y-m-d', strtotime('+14 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(9, 1, date('Y-m-d', strtotime('+14 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(9, 1, date('Y-m-d', strtotime('+14 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(9, 1, date('Y-m-d', strtotime('+14 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(10, 1, date('Y-m-d', strtotime('+21 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(10, 1, date('Y-m-d', strtotime('+21 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(10, 1, date('Y-m-d', strtotime('+21 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(10, 1, date('Y-m-d', strtotime('+21 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(10, 1, date('Y-m-d', strtotime('+21 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(11, 1, date('Y-m-d', strtotime('+10 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(11, 1, date('Y-m-d', strtotime('+10 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(11, 1, date('Y-m-d', strtotime('+10 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(11, 1, date('Y-m-d', strtotime('+10 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(11, 1, date('Y-m-d', strtotime('+10 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(12, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(12, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(12, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(12, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(12, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(13, 1, date('Y-m-d', strtotime('-2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(13, 1, date('Y-m-d', strtotime('-2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(13, 1, date('Y-m-d', strtotime('-2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(13, 1, date('Y-m-d', strtotime('-2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(13, 1, date('Y-m-d', strtotime('-2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(14, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(14, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(14, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(14, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(14, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(15, 1, date('Y-m-d', strtotime('-2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(15, 1, date('Y-m-d', strtotime('-2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(15, 1, date('Y-m-d', strtotime('-2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-30 days')), $this->RandomPrice());
			$stockService->AddProduct(15, 1, date('Y-m-d', strtotime('-2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(15, 1, date('Y-m-d', strtotime('-2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddProduct(21, 1500, date('Y-m-d', strtotime('+200 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(21, 2500, date('Y-m-d', strtotime('+200 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(22, 1, date('Y-m-d', strtotime('+200 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-10 days')), $this->RandomPrice());
			$stockService->AddProduct(22, 1, date('Y-m-d', strtotime('+200 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-20 days')), $this->RandomPrice());
			$stockService->AddProduct(23, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-40 days')), $this->RandomPrice());
			$stockService->AddProduct(23, 1, date('Y-m-d', strtotime('+2 days')), StockService::TRANSACTION_TYPE_PURCHASE, date('Y-m-d', strtotime('-50 days')), $this->RandomPrice());
			$stockService->AddMissingProductsToShoppingList();
			$stockService->OpenProduct(3, 1);
			$stockService->OpenProduct(6, 1);
			$stockService->OpenProduct(22, 1);
			$stockService->ConsumeProduct(11, 1, true, StockService::TRANSACTION_TYPE_CONSUME);

			$choresService = new ChoresService();
			$choresService->TrackChore(1, date('Y-m-d H:i:s', strtotime('-5 days')));
			$choresService->TrackChore(1, date('Y-m-d H:i:s', strtotime('-10 days')));
			$choresService->TrackChore(1, date('Y-m-d H:i:s', strtotime('-15 days')));
			$choresService->TrackChore(2, date('Y-m-d H:i:s', strtotime('-10 days')));
			$choresService->TrackChore(2, date('Y-m-d H:i:s', strtotime('-20 days')));
			$choresService->TrackChore(3, date('Y-m-d H:i:s', strtotime('-17 days')));
			$choresService->TrackChore(4, date('Y-m-d H:i:s', strtotime('-10 days')));
			$choresService->TrackChore(5, date('Y-m-d H:i:s', strtotime('+0 days')));
			$choresService->TrackChore(6, date('Y-m-d H:i:s', strtotime('-10 days')));

			$batteriesService = new BatteriesService();
			$batteriesService->TrackChargeCycle(1, date('Y-m-d H:i:s', strtotime('-200 days')));
			$batteriesService->TrackChargeCycle(1, date('Y-m-d H:i:s', strtotime('-150 days')));
			$batteriesService->TrackChargeCycle(1, date('Y-m-d H:i:s', strtotime('-100 days')));
			$batteriesService->TrackChargeCycle(1, date('Y-m-d H:i:s', strtotime('-50 days')));
			$batteriesService->TrackChargeCycle(2, date('Y-m-d H:i:s', strtotime('-200 days')));
			$batteriesService->TrackChargeCycle(2, date('Y-m-d H:i:s', strtotime('-150 days')));
			$batteriesService->TrackChargeCycle(2, date('Y-m-d H:i:s', strtotime('-100 days')));
			$batteriesService->TrackChargeCycle(2, date('Y-m-d H:i:s', strtotime('-50 days')));
			$batteriesService->TrackChargeCycle(3, date('Y-m-d H:i:s', strtotime('-65 days')));
			$batteriesService->TrackChargeCycle(4, date('Y-m-d H:i:s', strtotime('-56 days')));

			// Download demo storage data
			$productPicturesFolder = GROCY_DATAPATH . '/storage/productpictures';
			$equipmentManualsFolder = GROCY_DATAPATH . '/storage/equipmentmanuals';
			$recipePicturesFolder = GROCY_DATAPATH . '/storage/recipepictures';
			mkdir(GROCY_DATAPATH . '/storage');
			mkdir($productPicturesFolder);
			mkdir($equipmentManualsFolder);
			mkdir($recipePicturesFolder);
			$sslOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				),
			);
			file_put_contents("$productPicturesFolder/cookies.jpg", file_get_contents('https://releases.grocy.info/demoresources/cookies.jpg', false, stream_context_create($sslOptions)));
			file_put_contents("$productPicturesFolder/cucumber.jpg", file_get_contents('https://releases.grocy.info/demoresources/cucumber.jpg', false, stream_context_create($sslOptions)));
			file_put_contents("$productPicturesFolder/gummybears.jpg", file_get_contents('https://releases.grocy.info/demoresources/gummybears.jpg', false, stream_context_create($sslOptions)));
			file_put_contents("$productPicturesFolder/paprika.jpg", file_get_contents('https://releases.grocy.info/demoresources/paprika.jpg', false, stream_context_create($sslOptions)));
			file_put_contents("$productPicturesFolder/tomato.jpg", file_get_contents('https://releases.grocy.info/demoresources/tomato.jpg', false, stream_context_create($sslOptions)));
			file_put_contents("$equipmentManualsFolder/loremipsum.pdf", file_get_contents('https://releases.grocy.info/demoresources/loremipsum.pdf', false, stream_context_create($sslOptions)));
			file_put_contents("$recipePicturesFolder/pizza.jpg", file_get_contents('https://releases.grocy.info/demoresources/pizza.jpg', false, stream_context_create($sslOptions)));
			file_put_contents("$recipePicturesFolder/sandwiches.jpg", file_get_contents('https://releases.grocy.info/demoresources/sandwiches.jpg', false, stream_context_create($sslOptions)));
			file_put_contents("$recipePicturesFolder/pancakes.jpg", file_get_contents('https://releases.grocy.info/demoresources/pancakes.jpg', false, stream_context_create($sslOptions)));
			file_put_contents("$recipePicturesFolder/spaghetti.jpg", file_get_contents('https://releases.grocy.info/demoresources/spaghetti.jpg', false, stream_context_create($sslOptions)));
			file_put_contents("$recipePicturesFolder/chocolate_sauce.jpg", file_get_contents('https://releases.grocy.info/demoresources/chocolate_sauce.jpg', false, stream_context_create($sslOptions)));
			file_put_contents("$recipePicturesFolder/pancakes_chocolate_sauce.jpg", file_get_contents('https://releases.grocy.info/demoresources/pancakes_chocolate_sauce.jpg', false, stream_context_create($sslOptions)));
		}
	}

	private function RandomPrice()
	{
		return mt_rand(2 * 100, 25 * 100) / 100;
	}

	private function __t_sql(string $text)
	{
		$localizedText = $this->LocalizationService->__t($text, null);
		return str_replace("'", "''", $localizedText);
	}

	private function __n_sql($number, string $singularForm, string $pluralForm)
	{
		$localizedText = $this->LocalizationService->__n($number, $singularForm, $pluralForm);
		return str_replace("'", "''", $localizedText);
	}
}
