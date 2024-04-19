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
            function sendError($message) {
                echo json_encode(array("error" => $message));
                exit();
            } try {
                //voir tous les produits
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
                
                //consulter les employés d'un magasin
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

                //consulter les stocks d'un magasin
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

                //consulter les employés de tous les magasins
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

                //consulter les employés de tous les magasins
                else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="getAddresses") {
                    $stores = $storesRepository->findAll();
                    foreach ($stores as $store) {
                        $response[] = array(
                            "addresse" => $store->getCity(),
                        );
                    } 
                    echo json_encode($response);
                }

                /*//avoir l'it selon le mot de passe et le mail
                else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="getLoginIt") {
                    $stores = $storesRepository->findAll();
                    foreach ($stores as $store) {
                        $response[] = array(
                            "addresse" => $store->getCity(),
                        );
                    } 
                    echo json_encode($response);
                }

                //avoir le chef selon le mot de passe et le mail
                else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="getLoginChief") {
                    $stores = $storesRepository->findAll();
                    foreach ($stores as $store) {
                        $response[] = array(
                            "addresse" => $store->getCity(),
                        );
                    } 
                    echo json_encode($response);
                }*/
            } catch (Exception $e) {
                sendError($e->getMessage());
            }
            break;
        case "POST" :
            function sendError($message) {
                echo json_encode(array("error" => $message));
                exit();
            } try {
                if (isset($_REQUEST["auth_key"]) && $_REQUEST["auth_key"] == "e8f1997c763") {
                    //ajouter un employé à un magasin
                    if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addEmployeeToStore") {
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

                    //ajouter une marque
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addBrand") {
                        $name = $_REQUEST["brand_name"];
                        $brand = new Brands();
                        $brand->setBrandId(0);
                        $brand->setBrandName($name);
                        $entityManager->persist($brand);
                        $entityManager->flush();
                        echo json_encode('Saved new brand.');
                    }

                    //ajouter une catégorie
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addCategory") {
                        $name = $_REQUEST["category_name"];
                        $category = new Categories();
                        $category->setCategoryId(0);
                        $category->setCategoryName($name);
                        $entityManager->persist($category);
                        $entityManager->flush();
                        echo json_encode('Saved new category.');
                    }

                    //ajouter un produit
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addProduct") {
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

                    //ajouter un stock
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addStock") {
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

                    //ajouter un magasin
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="addStore") {
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

                    //connexion
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
            function sendError($message) {
                echo json_encode(array("error" => $message));
                exit();
            } try {
                $json = file_get_contents("php://input");
                $data = json_decode($json, true);

                if (isset($_REQUEST["auth_key"]) && $_REQUEST["auth_key"] == "e8f1997c763") {
                    //modifier une marque
                    if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="editBrand") {
                        $name = $data["brand_name"];
                        $brand = $brandsRepository->find($data["brand_id"]);
                        $brand->setBrandName($name);
                        $entityManager->persist($brand);
                        $entityManager->flush();
                        echo json_encode('Saved edit for brand of id '.$brand->getBrandId());
                    }

                    //modifier une catégorie
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="editCategory") {
                        $name = $data["category_name"];
                        $category = $categoriesRepository->find($data["category_id"]);
                        $category->setCategoryName($name);
                        $entityManager->persist($category);
                        $entityManager->flush();
                        echo json_encode('Saved edit for category of id '.$category->getCategoryId());
                    }

                    //modifier un produit
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="editProduct") {
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

                    //modifier un stock
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="editStock") {
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

                    //modifier un magasin
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="editStore") {
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

                    //modifier un login
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="changeLogin") {
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
            function sendError($message) {
                echo json_encode(array("error" => $message));
                exit();
            } try {
                $json = file_get_contents("php://input");
                $data = json_decode($json, true);
                
                if (isset($_REQUEST["auth_key"]) && $_REQUEST["auth_key"] == "e8f1997c763") {
                    //supprimer une marque
                    if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="deleteBrand") {
                        $brand_id = $data["brand_id"];
                        $brand = $brandsRepository->find($brand_id);
                        $entityManager->remove($brand);
                        $entityManager->flush();
                        echo json_encode('Deleted brand.');
                    }

                    //supprimer une catégorie
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="deleteCategory") {
                        $category_id = $data["category_id"];
                        $category = $categoriesRepository->find($category_id);
                        $entityManager->remove($category);
                        $entityManager->flush();
                        echo json_encode('Deleted category.');
                    }

                    //supprimer un produit
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="deleteProduct") {
                        $product_id = $data["product_id"];
                        $product = $productsRepository->find($product_id);
                        $entityManager->remove($product);
                        $entityManager->flush();
                        echo json_encode('Deleted product.');
                    }

                    //supprimer un stock
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="deleteStock") {
                        $stock_id = $data["stock_id"];
                        $stock = $stocksRepository->find($stock_id);
                        $entityManager->remove($stock);
                        $entityManager->flush();
                        echo json_encode('Deleted stock.');
                    }

                    //supprimer un magasin
                    else if(!empty($_REQUEST["action"]) && $_REQUEST["action"]=="deleteStore") {
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