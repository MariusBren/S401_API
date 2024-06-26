<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Control-Type: application/json;cherset=UTF-8");

    require __DIR__ . '/bootstrap.php';
    use Entity\Brands;
    use Entity\Categories;
    use Entity\Products;
    use Entity\Stocks;
    use Entity\Stores;
    use Entity\Employees;

    $brandsRepository = $entityManager->getRepository(Brands::class);
    $categoriesRepository = $entityManager->getRepository(Categories::class);
    $productsRepository = $entityManager->getRepository(Products::class);
    $stocksRepository = $entityManager->getRepository(Stocks::class);
    $storesRepository = $entityManager->getRepository(Stores::class);
    $employeesRepository = $entityManager->getRepository(Employees::class);

    $method = $_SERVER["REQUEST_METHOD"];
    switch($method) {
        case "GET" :
            /**
             * Send error response in JSON format.
             * 
             * @param string $message The error message to be sent.
             * @return void
             */
            function sendError($message) {
                echo json_encode(array("error" => $message));
                exit();
            } try {
                if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="getAllProducts") {
                    $produits = $productsRepository->findAll();
                    foreach ($produits as $produit) {
                        $response[] = array(
                            "id" => $produit->getProductId(),
                            "name" => $produit->getProductName(),
                            "brand" => $produit->getBrandId()->getBrandName(),
                            "category" => $produit->getCategoryId()->getCategoryName(),
                            "model_year" => $produit->getModelYear(),
                            "list_price" => $produit->getListPrice(),
                        );
                    }
                    echo json_encode($response);
                }
                
                else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="getEmployeeFromStore") {
                    $store_id = $_REQUEST["store_id"];
                    $employees = $employeesRepository->findBy(["store_id"=>$store_id]);
                    foreach ($employees as $employee) {
                        $response[] = array(
                            "employee_id" => $employee->getEmployeeId(),
                            "employee_name" => $employee->getEmployeeName(),
                            "employee_email" => $employee->getEmployeeEmail(),
                            "employee_role" => $employee->getEmployeeRole(),
                            "employee_store" => $employee->getStoreId()->getCity(),
                        );
                    } 
                    echo json_encode($response);
                }

                else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="getStocksFromStore") {
                    $store_id = $_REQUEST["store_id"];
                    $stocks = $stocksRepository->findBy(["store_id"=>$store_id]);
                    foreach ($stocks as $stock) {
                        $response[] = array(
                            "stock_id" => $stock->getStockId(),
                        );
                    } 
                    echo json_encode($response);
                }

                else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="getEmployeeFromAll") {
                    $employees = $employeesRepository->findAll();
                    foreach ($employees as $employee) {
                        $response[] = array(
                            "employee_id" => $employee->getEmployeeId(),
                            "employee_name" => $employee->getEmployeeName(),
                            "employee_email" => $employee->getEmployeeEmail(),
                            "employee_role" => $employee->getEmployeeRole(),
                            "employee_store" => $employee->getStoreId()->getCity(),
                        );
                    } 
                    echo json_encode($response);
                }

                else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="getAddresses") {
                    $stores = $storesRepository->findAll();
                    foreach ($stores as $store) {
                        $response[] = array(
                            "addresse" => $store->getCity(),
                        );
                    } 
                    echo json_encode($response);
                }

            } catch (Exception $e) {
                sendError($e->getMessage());
            }
            break;
        case "POST" :
            /**
             * Send error response in JSON format.
             * 
             * @param string $message The error message to be sent.
             * @return void
             */
            function sendError($message) {
                echo json_encode(array("error" => $message));
                exit();
            } try {
                if (isset($_REQUEST["auth_key"]) && $_REQUEST["auth_key"] == "e8f1997c763") {
                    if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addEmployeeToStore") {
                        $required_fields = ["store_id", "employee_name", "employee_email", "employee_password", "employee_role"];
                        foreach ($required_fields as $field) {
                            if (empty($_REQUEST[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $store_id = $_REQUEST["store_id"];
                        $store = $storesRepository->find($store_id);
                        $name = $_REQUEST["employee_name"];
                        $email = $_REQUEST["employee_email"];
                        $password = $_REQUEST["employee_password"];
                        $role = $_REQUEST["employee_role"];
                        $employee = new Employees();
                        $employee->setEmployeeId(0);
                        $employee->setStoreId($store);
                        $employee->setEmployeeName($name);
                        $employee->setEmployeeEmail($email);  
                        $employee->setEmployeePassword($password);
                        $employee->setEmployeeRole($role);
                        $entityManager->persist($employee);
                        $entityManager->flush();
                        echo json_encode('Saved new employee at store.');
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addBrand") {
                        $required_fields = ["brand_name"];
                        foreach ($required_fields as $field) {
                            if (empty($_REQUEST[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $name = $_REQUEST["brand_name"];
                        $brand = new Brands();
                        $brand->setBrandId(0);
                        $brand->setBrandName($name);
                        $entityManager->persist($brand);
                        $entityManager->flush();
                        echo json_encode('Saved new brand.');
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addCategory") {
                        $required_fields = ["category_name"];
                        foreach ($required_fields as $field) {
                            if (empty($_REQUEST[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $name = $_REQUEST["category_name"];
                        $category = new Categories();
                        $category->setCategoryId(0);
                        $category->setCategoryName($name);
                        $entityManager->persist($category);
                        $entityManager->flush();
                        echo json_encode('Saved new category.');
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addProduct") {
                        $required_fields = ["product_name", "brand_id", "category_id", "model_year", "list_price"];
                        foreach ($required_fields as $field) {
                            if (empty($_REQUEST[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $name = $_REQUEST["product_name"];
                        $brand_id = $_REQUEST["brand_id"];
                        $brand = $brandsRepository->find($brand_id);
                        $category_id = $_REQUEST["category_id"];
                        $category = $categoriesRepository->find($category_id);
                        $model_year = $_REQUEST["model_year"];
                        $list_price = $_REQUEST["list_price"];
                        $product = new Products();
                        $product->setProductId(0);
                        $product->setProductName($name);
                        $product->setBrandId($brand);
                        $product->setCategoryId($category);
                        $product->setModelYear($model_year);
                        $product->setListPrice($list_price);
                        $entityManager->persist($product);
                        $entityManager->flush();
                        echo json_encode('Saved new product.');
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addStock") {
                        $required_fields = ["store_id", "product_id", "quantity"];
                        foreach ($required_fields as $field) {
                            if (empty($_REQUEST[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $store_id = $_REQUEST["store_id"];
                        $store = $storesRepository->find($store_id);
                        $product_id = $_REQUEST["product_id"];
                        $product = $productsRepository->find($product_id);
                        $quantity = $_REQUEST["quantity"];
                        $stock = new Stocks();
                        $stock->setStockId(0);
                        $stock->setStoreId($store);
                        $stock->setProductId($product);
                        $stock->setQuantity($quantity);
                        $entityManager->persist($stock);
                        $entityManager->flush();
                        echo json_encode('Saved new stock.');
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addStore") {
                        $required_fields = ["store_name", "phone", "email","street","city","state","zip_code"];
                        foreach ($required_fields as $field) {
                            if (empty($_REQUEST[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $name = $_REQUEST["store_name"];
                        $phone = $_REQUEST["phone"];
                        $email = $_REQUEST["email"];
                        $street = $_REQUEST["street"];
                        $city = $_REQUEST["city"];
                        $state = $_REQUEST["state"];
                        $zip_code = $_REQUEST["zip_code"];
                        $store = new Stores();
                        $store->setStoreId(0);
                        $store->setStoreName($name);
                        $store->setPhone($phone);
                        $store->setEmail($email);
                        $store->setStreet($street);
                        $store->setCity($city);
                        $store->setState($state);
                        $store->setZipCode($zip_code);
                        $entityManager->persist($store);
                        $entityManager->flush();
                        echo json_encode('Saved new store.');
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="getLoginEmployee") {
                        $email = $_REQUEST["email"];
                        $password = $_REQUEST["password"];
                        $employee = $employeesRepository->findOneBy(["employee_email" => $email, "employee_password" => $password]);
                        $storeId = $employee->getStoreId();
                        $store = $storesRepository->find($storeId);
                        $response[] = array(
                            "employee_id" => $employee->getEmployeeId(),
                            "role" => $employee->getEmployeeRole(),
                            "store_id" => $store->getStoreId(),
                        );
                        echo json_encode($response);
                    }
                    
                } else {
                    echo json_encode(array("error" => "Clé d'authentification invalide."));
                }
            } catch (Exception $e) {
                sendError($e->getMessage());
            }
            break;
            
        case "PUT" :
            /**
             * Send error response in JSON format.
             * 
             * @param string $message The error message to be sent.
             * @return void
             */
            function sendError($message) {
                echo json_encode(array("error" => $message));
                exit();
            } try {
                $json = file_get_contents("php://input");
                $data = json_decode($json, true);

                if (isset($_REQUEST["auth_key"]) && $_REQUEST["auth_key"] == "e8f1997c763") {
                    if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="editBrand") {
                        $required_fields = ["brand_name", "brand_id"];
                        foreach ($required_fields as $field) {
                            if (empty($data[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $name = $data["brand_name"];
                        $brand = $brandsRepository->find($data["brand_id"]);
                        $brand->setBrandName($name);
                        $entityManager->persist($brand);
                        $entityManager->flush();
                        echo json_encode('Saved edit for brand of id '.$brand->getBrandId());
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="editCategory") {
                        $required_fields = ["category_name", "category_id"];
                        foreach ($required_fields as $field) {
                            if (empty($data[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $name = $data["category_name"];
                        $category = $categoriesRepository->find($data["category_id"]);
                        $category->setCategoryName($name);
                        $entityManager->persist($category);
                        $entityManager->flush();
                        echo json_encode('Saved edit for category of id '.$category->getCategoryId());
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="editProduct") {
                        $required_fields = ["product_id", "product_name", "brand_id", "category_id", "model_year", "list_price"];
                        foreach ($required_fields as $field) {
                            if (empty($data[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $product = $productsRepository->find($data["product_id"]);
                        $name = $data["product_name"];
                        $brand_id = $data["brand_id"];
                        $brand = $brandsRepository->find($brand_id);
                        $category_id = $data["category_id"];
                        $category = $categoriesRepository->find($category_id);
                        $product_id = $data["product_id"];
                        $model_year = $data["model_year"];
                        $list_price = $data["list_price"];
                        $product->setProductName($name);
                        $product->setBrandId($brand);
                        $product->setCategoryId($category);
                        $product->setModelYear($model_year);
                        $product->setListPrice($list_price);
                        $entityManager->persist($product);
                        $entityManager->flush();
                        echo json_encode('Saved edit for product of id '.$product->getProductId());
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="editStock") {
                        $required_fields = ["stock_id", "store_id", "quantity"];
                        foreach ($required_fields as $field) {
                            if (empty($data[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $stock = $stocksRepository->find($data["stock_id"]);
                        $store_id = $data["store_id"];
                        $store = $storesRepository->find($store_id);
                        $quantity = $data["quantity"];
                        $stock->setStoreId($store);
                        $stock->setQuantity($quantity);
                        $entityManager->persist($stock);
                        $entityManager->flush();
                        echo json_encode('Saved edit for stock of id '.$stock->getStockId());
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="editStore") {
                        $required_fields = ["store_id", "store_name", "phone", "email", "street", "city", "state", "zip_code"];
                        foreach ($required_fields as $field) {
                            if (empty($data[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $store = $storesRepository->find($data["store_id"]);
                        $name = $data["store_name"];
                        $phone = $data["phone"];
                        $email = $data["email"];
                        $street = $data["street"];
                        $city = $data["city"];
                        $state = $data["state"];
                        $zip_code = $data["zip_code"];
                        $store->setStoreName($name);
                        $store->setPhone($phone);
                        $store->setEmail($email);
                        $store->setStreet($street);
                        $store->setCity($city);
                        $store->setState($state);
                        $store->setZipCode($street);
                        $entityManager->persist($store);
                        $entityManager->flush();
                        echo json_encode('Saved edit for store of id '.$store->getStoreId());
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="changeLogin") {
                        $required_fields = ["id", "email", "pwd"];
                        foreach ($required_fields as $field) {
                            if (empty($data[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $employee = $employeesRepository->find($data["id"]);
                        $email = $data["email"];
                        $pwd = $data["pwd"];
                        $employee->setEmployeeEmail($email);
                        $employee->setEmployeePassword($pwd);
                        $entityManager->persist($employee);
                        $entityManager->flush();
                        echo json_encode('Saved new login for employee of id '.$employee->getEmployeeId());
                    }
                } else {
                    echo json_encode(array("error" => "Clé d'authentification invalide."));
                }
            } catch (Exception $e) {
                sendError($e->getMessage());
            }
            break;
        
        case "DELETE" :
            /**
             * Send error response in JSON format.
             * 
             * @param string $message The error message to be sent.
             * @return void
             */
            function sendError($message) {
                echo json_encode(array("error" => $message));
                exit();
            } try {
                $json = file_get_contents("php://input");
                $data = json_decode($json, true);
                
                if (isset($_REQUEST["auth_key"]) && $_REQUEST["auth_key"] == "e8f1997c763") {
                    if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="deleteBrand") {
                        $required_fields = ["brand_id"];
                        foreach ($required_fields as $field) {
                            if (empty($data[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $brand_id = $data["brand_id"];
                        $brand = $brandsRepository->find($brand_id);
                        $entityManager->remove($brand);
                        $entityManager->flush();
                        echo json_encode('Deleted brand.');
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="deleteCategory") {
                        $required_fields = ["category_id"];
                        foreach ($required_fields as $field) {
                            if (empty($data[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $category_id = $data["category_id"];
                        $category = $categoriesRepository->find($category_id);
                        $entityManager->remove($category);
                        $entityManager->flush();
                        echo json_encode('Deleted category.');
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="deleteProduct") {
                        $required_fields = ["product_id"];
                        foreach ($required_fields as $field) {
                            if (empty($data[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $product_id = $data["product_id"];
                        $product = $productsRepository->find($product_id);
                        $entityManager->remove($product);
                        $entityManager->flush();
                        echo json_encode('Deleted product.');
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="deleteStock") {
                        $required_fields = ["stock_id"];
                        foreach ($required_fields as $field) {
                            if (empty($data[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $stock_id = $data["stock_id"];
                        $stock = $stocksRepository->find($stock_id);
                        $entityManager->remove($stock);
                        $entityManager->flush();
                        echo json_encode('Deleted stock.');
                    }

                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="deleteStore") {
                        $required_fields = ["store_id"];
                        foreach ($required_fields as $field) {
                            if (empty($data[$field])) {
                                sendError("Missing or empty field: " . $field);
                                exit();
                            }
                        }
                        $store_id = $data["store_id"];
                        $store = $storesRepository->find($store_id);
                        $entityManager->remove($store);
                        $entityManager->flush();
                        echo json_encode('Deleted store.');
                    }
                } else {
                    echo json_encode(array("error" => "Clé d'authentification invalide."));
                }
            
            } catch (Exception $e) {
                sendError($e->getMessage());
            }
            break;
    }
?>