INSERT INTO product (category,product_name,product_type,quantity,units,batch_number,mfg_date,expiry_date,selling_price,gst,product_code,created_by,created_at,updated_at,modified_by,actual_price) VALUES
	 (26,'MYSQL ','Service',8,'Nos','B-5 ','2019-02-22','2030-02-22',790,'5% ','MY-1 ',1,'2021-02-19 15:02:40','2021-02-19 15:03:56',1,890),
	 (20,'PHP Book  with oops concept ','Sales',5,'Nos','B-234   ','2019-02-26','2031-02-26',800,'1%   ','PHP - C1  and PHP - C2 ',1,'2021-02-19 14:51:27','2021-02-22 08:04:44',1,1000),
	 (15,'Codeignter - Development','Sales',2,'Nos','b-23 ','2021-02-27','2021-02-23',400,'5% ','p-1 ',1,'2021-02-22 08:43:36','2021-02-22 08:46:12',1,500),
	 (34,'MYISAM is a default engine  ','Service',5,'Nos','B-25  ','2019-02-22','2029-02-22',1150,'8%  ','MY-12345  ',1,'2021-02-22 06:21:26','2021-02-22 08:51:33',1,2000),
	 (15,'Framework ','Sales',5,'Nos','b-21  ','2021-02-27','2021-02-24',567,'9  ','F12  ',1,'2021-02-22 08:54:00','2021-02-22 08:57:38',1,123),
	 (22,'framework ','Service',10,'Nos','CODE 12345     ','2019-02-05','2030-02-05',580,'6%     ','CODE 345     ',1,'2021-02-19 16:46:46','2021-02-22 08:59:25',1,550);

	 $query1 = ProductModel::select('*');
            $query1->where(function($query1) use($request, $searchFields){
              $searchWildcard = '%' . $request->search . '%';
            //   foreach($searchFields as $field){
            //     $query1->orWhere($field, 'LIKE', $searchWildcard);
            //   }
              print_r($query1); exit;

            });
             if ($input['product_name']) {
                            $query->orWhere('product_name', 'like', '%' . $product_name . '%');
                        }
                        if ($input['product_type']) {
                            $query->Where('product_type', '=', '' . $input['product_type'] . '');
                        }
                        if ($input['mfg_date']) {
                            $query->Where('mfg_date', '=', '' . $input['mfg_date'] . '');
                        }
                        if ($input['expiry_date']) {
                            $query->Where('expiry_date', '=', '' . $input['expiry_date'] . '');
                        }
                        if ($input['actual_price']) {
                            $query->Where('actual_price', '=', '' . $input['actual_price'] . '');
                        }