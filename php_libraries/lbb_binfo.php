<?php

class lbb_business_info {
    
    function __construct(){
        
    }
    function  return_business_cat_select($args){
        $business_cats = $this->return_business_cats();
        $select = '<select name="' . $args["option_name"] . '[' . $args["ID"] . ']" id="'.$args['ID'].'" class="'.$args['class'].'">';
        $select .= '<option value="'.$args['default'].'" '.( ($args['value'] != '') ? 'selected' : '' ).' disabled>'.$args['default'].'</option>';
        foreach($business_cats as $id => $dets){  
                $select .= '<option '. $dets['title'] .' value="'. $dets['title'] .'" '.( ($dets['title'] == $args['value']) ? 'selected' : '' ).'>'. $dets['title'] .'</option>'; 
                if($dets['parent'] && isset($dets['children'])){
                    if(is_array($dets['children']) && !empty($dets['children'])){
                        foreach($dets['children'] as $id => $detz){
                            $select .= '<option '. $detz['title'] .' value="'. $detz['title'] .'" '.( ($detz['title'] == $args['value']) ? 'selected' : '' ).'> --'. $detz['title'] .'</option>';    
                        }
                    }    
                }                
        }
        $select .= '</select>';
        return $select;
    }
    function return_24h_select($args){
       
        $select = '<select name="' . $args["name"] . '" id="'.$args['ID'].'" class="'.$args['class'].' no-select-2">';
        $select .= '<option value="'.$args['default'].'" '.( ($args['value'] != '') ? 'selected' : '' ).' disabled>'.$args['default'].'</option>';
        for($hours=0; $hours<24; $hours++){
            for($mins=0; $mins<60; $mins+=30){ 
                $time = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
                $select .= '<option '.( ($args['value'] == $time) ? 'selected' : '' ).' value="'.$time.'">'.$time.'</option>';                 
            }
        }
        $select .= '</select>';
    return $select;
    }
    function return_country_select($args){
        $countries = $this->return_countrys();
        $select = '<select name="' . $args["option_name"] . '[' . $args["ID"] . ']" id="'.$args['ID'].'" class="'.$args['class'].'">';
        $select .= '<option value="'.$args['default'].'" '.( ($args['value'] != '') ? 'selected' : '' ).' disabled>'.$args['default'].'</option>';
        if(is_array($countries) && !empty($countries)){
            foreach($countries as $id => $title){
                $select .= '<option '.( ($args['value'] == $id) ? 'selected' : '' ).' value="'.$id.'">'.$title.'</option>';                 
            }    
        }
        $select .= '</select>';
    return $select;
    return $select;
    }
    function return_state_select($args){
        $states = $this->return_state_array($args['country']);
        $select = '<select name="' . $args["option_name"] . '[' . $args["ID"] . ']" id="'.$args['ID'].'" class="'.$args['class'].'">';
        $select .= '<option value="'.$args['default'].'" '.( ($args['value'] != '') ? 'selected' : '' ).' disabled>'.$args['default'].'</option>';
        if($states && is_array($states) && !empty($states)){
            foreach($states as $id => $title){
                $select .= '<option '.( ($args['value'] == $id) ? 'selected' : '' ).' value="'.$id.'">'.$title.'</option>';                 
            }    
        }
        $select .= '</select>';
    return $select;
    }
    function return_countrys(){
        $country_array = array(
            'AU' 
                    => 'Australia',
            'EU'    
                    => 'Europe'
        );
        return $country_array;
    }
    function return_state_array($country_code){
        $state_array = array(
            'EU' 
                    => array(
                        'TEST'
                                =>'Test Country'
            ),
            'AU' 
                    => array(
                        'QLD'
                                =>'Queensland', 
                        'NSW'
                                =>'New South Wales', 
                        'SA'
                                =>'South Australia', 
                        'WA'
                                =>'Western Australia', 
                        'VIC'
                                =>'Victoria', 
                        'NT'
                                =>'Northern Territory', 
                        'ACT'
                                =>'Australian Capital Territory'
            )
        );
        
        return (isset($state_array[$country_code]) ? $state_array[$country_code] : false);
        
    }
    function return_business_cats(){
        $bunsiess_type = array (
                'LocalBusiness'             => array(
                                                'parent'    => false, 
                                                'title'     => 'LocalBusiness'),
                'AnimalShelter'             => array(
                                                'parent'    => false, 
                                                'title'     => 'Animal Shelter'),
                'AutomotiveBusiness'        
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Automotive Business - General',
                                                'children'  
                                                            => array(
                                                            'AutoBodyShop'      
                                                                                => array(
                                                                                 'title' => 'Auto Body Shop'),
                                                            'AutoDealer'        
                                                                                => array(
                                                                                 'title' => 'Auto Dealer'),        
                                                            'AutoPartsStore'    
                                                                                => array(
                                                                                 'title' => 'Auto Parts Store'),
                                                            'AutoRental'        
                                                                                => array(
                                                                                 'title' => 'Auto Rental'),
                                                            'AutoWash'          
                                                                                => array(
                                                                                 'title' => 'Auto Wash'),
                                                            'MotorcycleDealer'  
                                                                                => array(
                                                                                 'title' => 'Motorcycle Dealer'),
                                                            'MotorcycleRepair'  
                                                                                => array(
                                                                                 'title' => 'Motorcycle Repair')                                                                                      
                                                            )
                                                ),
                'ChildCare'                 => array(
                                                'parent'    => false, 
                                                'title'     => 'Child Care'),
                'Dentist'                   => array(
                                                'parent'    => false, 
                                                'title'     => 'Dentist'),
                'DryCleaningOrLaundry'      => array(
                                                'parent'    => false, 
                                                'title'     => 'DryCleaningOrLaundry'), 
                'EmergencyService'          
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Emergency Service - General',
                                                'children'  
                                                            => array(
                                                            'FireStation'       
                                                                                => array(
                                                                                 'title' => 'Firestation'),
                                                            'Hospital'          
                                                                                => array(
                                                                                 'title' => 'Hospital'),        
                                                            'PoliceStation'     
                                                                                => array(
                                                                                 'title' => 'Police Station')                                                                                     
                                                            )
                                                ),
                                                
                'Employment Agency'         
                                            => array(
                                                'parent'    => false, 
                                                'title'     => 'Employment Agency'),                                
                'EntertainmentBusiness'     
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Entertainment Business - General',
                                                'children'  
                                                            => array(
                                                            'AdultEntertainment'
                                                                                => array(
                                                                                 'title' => 'Adult Entertainment'),
                                                            'AmusementPark'     
                                                                                => array(
                                                                                 'title' => 'Amusement Park'),        
                                                            'ArtGallery'        
                                                                                => array(
                                                                                 'title' => 'Art Gallery'),
                                                            'Casino'            
                                                                                => array(
                                                                                 'title' => 'Casino'),
                                                            'ComedyClub'        
                                                                                => array(
                                                                                 'title' => 'Comedy Club'),                     
                                                            'MovieTheater'      
                                                                                => array(
                                                                                 'title' => 'Movie Theater'),                                         
                                                            'NightClub'         
                                                                                => array(
                                                                                 'title' => 'Night Club')                                                                                                                               
                                                            )
                                                ),
                                                                                
                'FinancialService'          
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Financial Service - General', 
                                                'children'  
                                                            => array(
                                                            'AccountingService' 
                                                                                => array(
                                                                                 'title' => 'Accounting Service'),
                                                            'AutomatedTeller'   
                                                                                => array(
                                                                                 'title' => 'Automated Teller'),        
                                                            'BankOrCreditUnion' 
                                                                                => array(
                                                                                 'title' => 'Bank or Credit Union'),
                                                            'InsuranceAgency'   
                                                                                => array(
                                                                                 'title' => 'Insurance Agency')                                                                                                                              
                                                            )
                                                ),                            
                'FoodEstablishment'         
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Food Establishment - General', 
                                                'children'  
                                                            => array(
                                                            'Bakery'            
                                                                                => array(
                                                                                 'title' => 'Bakery'),
                                                            'BarOrPub'          
                                                                                => array(
                                                                                 'title' => 'Bar or Pub'),        
                                                            'Brewery'           
                                                                                => array(
                                                                                 'title' => 'Brewery'),
                                                            'CafeOrCoffeeShop'  
                                                                                => array(
                                                                                 'title' => 'Cafe or Coffee Shop'),
                                                            'FastFoodRestaurant'
                                                                                => array(
                                                                                 'title' => 'Fast Food Restaurant'),
                                                            'IceCreamShop'      
                                                                                => array(
                                                                                 'title' => 'Ice Cream Shop'),
                                                            'Restaurant'        
                                                                                => array(
                                                                                 'title' => 'Restaurant'),
                                                            'Winery'            
                                                                                => array(
                                                                                 'title' => 'Winery'),                                                                                                                              
                                                            )
                                                ),       
                'GovernmentOffice'          
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Government Office', 
                                                'children'  
                                                            => array(
                                                            'PostOffice'        
                                                                                => array(
                                                                                 'title' => 'Post Office')                                                                                                                              
                                                            )
                                                ),
                'HealthAndBeautyBusiness'   
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Health and Beauty Business - General', 
                                                'children'  
                                                            => array(
                                                            'BeautySalon'       
                                                                                => array(
                                                                                 'title' => 'Beauty Salon'),
                                                            'DaySpa'            
                                                                                => array(
                                                                                 'title' => 'Day Spa'),        
                                                            'HairSalon'         
                                                                                => array(
                                                                                 'title' => 'Hair Salon'),
                                                            'HealthClub'        
                                                                                => array(
                                                                                 'title' => 'Health Club'),
                                                            'NailSalon'         
                                                                                => array(
                                                                                 'title' => 'Nail Salon'),
                                                            'TattooParlor'      
                                                                                => array(
                                                                                 'title' => 'Tattoo Parlor')                                                                                                                              
                                                            )
                                                ),                           
                'HomeAndConstructionBusiness'
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Home and Construction Business - General', 
                                                'children'  
                                                            => array(
                                                            'Electrician'       
                                                                                => array(
                                                                                 'title' => 'Electrician'),
                                                            'GeneralContractor' 
                                                                                => array(
                                                                                 'title' => 'General Contractor'),        
                                                            'HVACBusiness'      
                                                                                => array(
                                                                                 'title' => 'HVAC Business'),
                                                            'HousePainter'      
                                                                                => array(
                                                                                 'title' => 'House Painter'),
                                                            'Locksmith'         
                                                                                => array(
                                                                                 'title' => 'Locksmith'),
                                                            'MovingCompany'     
                                                                                => array(
                                                                                 'title' => 'Moving Company'),
                                                            'Plumber'           
                                                                                => array(
                                                                                 'title' => 'Plumber'), 
                                                            'RoofingContractor' 
                                                                                => array(
                                                                                 'title' => 'RoofingContractor'),                     
                                                                                                                                                                                                              
                                                            )
                                                ),
                'InternetCafe'              
                                            => array(
                                                'parent'    => false, 
                                                'title'     => 'Internet Cafe'),
                'LegalService'              
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Legal Service - General',
                                                'children'  
                                                            => array(
                                                            'Attorney'          
                                                                                => array(
                                                                                 'title' => 'Attorney'),
                                                            'Notary'            
                                                                                => array(
                                                                                 'title' => 'Notary')
                                                            )
                                                ),                    
                'Library'                   
                                            => array(
                                                'parent'    => false, 
                                                'title'     => 'Library'),
                'LodgingBusiness'           
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Lodging Business - General',
                                                'children'  
                                                            => array(
                                                            'BedAndBreakfast'   
                                                                                => array(
                                                                                 'title' => 'Bed &amp; Breakfast'),
                                                            'Campground'        
                                                                                => array(
                                                                                 'title' => 'Campground'),
                                                            'Hostel'            
                                                                                => array(
                                                                                 'title' => 'Hostel'),
                                                            'Hotel'             
                                                                                => array(
                                                                                 'title' => 'Hotel'),
                                                            'Motel'             
                                                                                => array(
                                                                                 'title' => 'Motel'),                     
                                                            'Resort'            
                                                                                => array(
                                                                                 'title' => 'Resort')                     
                                                            )
                                                ),
                'RadioStation'              
                                            => array(
                                                'parent'    => false, 
                                                'title'     => 'RadioStation'),                              
                'RealEstateAgent'           
                                            => array(
                                                'parent'    => false, 
                                                'title'     => 'Real Estate Agent'),                                
                'RecyclingCenter'           
                                            => array(
                                                'parent'    => false, 
                                                'title'     => 'Recycling Center'),                                
                                                
                 'SelfStorage'              
                                             => array(
                                                'parent'    => false, 
                                                'title'     => 'Self Storage'),
                 'ShoppingCenter'              
                                             => array(
                                                'parent'    => false, 
                                                'title'     => 'Shopping Center'),                               
                'SportsActivityLocation'           
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Sports Activity Location - General',
                                                'children'  
                                                            => array(
                                                            'BowlingAlley'   
                                                                                => array(
                                                                                 'title' => 'Bed &amp; Breakfast'),
                                                            'BowlingAlley'        
                                                                                => array(
                                                                                 'title' => 'Bowling Alley'),
                                                            'ExerciseGym'            
                                                                                => array(
                                                                                 'title' => 'Exercise Gym'),
                                                            'PublicSwimmingPool'             
                                                                                => array(
                                                                                 'title' => 'Public Swimming Pool'),
                                                            'SkiResort'             
                                                                                => array(
                                                                                 'title' => 'Ski Resort'),                     
                                                            'SportsClub'            
                                                                                => array(
                                                                                 'title' => 'Sports Club'),
                                                            'StadiumOrArena'            
                                                                                => array(
                                                                                 'title' => 'Stadium Or Arena'),
                                                            'TennisComplex'            
                                                                                => array(
                                                                                 'title' => 'Tennis Complex')                     
                                                            )
                                                ),
                'Store'           
                                            => array(
                                                'parent'    => true, 
                                                'title'     => 'Store - General',
                                                'children'  
                                                            => array(
                                                            'BikeStore'   
                                                                                => array(
                                                                                 'title' => 'Bike Store'),
                                                            'BookStore'        
                                                                                => array(
                                                                                 'title' => 'Book Store'),
                                                            'ClothingStore'            
                                                                                => array(
                                                                                 'title' => 'Clothing Store'),
                                                            'ComputerStore'             
                                                                                => array(
                                                                                 'title' => 'Computer Store'),
                                                            'ConvenienceStore'             
                                                                                => array(
                                                                                 'title' => 'Convenience Store'),                     
                                                            'DepartmentStore'            
                                                                                => array(
                                                                                 'title' => 'Department Store'),
                                                            'ElectronicsStore'            
                                                                                => array(
                                                                                 'title' => 'Electronics Store'),
                                                            'Florist'            
                                                                                => array(
                                                                                 'title' => 'Florist'),
                                                            'FurnitureStore'            
                                                                                => array(
                                                                                 'title' => 'Furniture Store'),                     
                                                            'GardenStore'            
                                                                                => array(
                                                                                 'title' => 'Garden Store'),                     
                                                            'GroceryStore'            
                                                                                => array(
                                                                                 'title' => 'Grocery Store'),
                                                            'HardwareStore'            
                                                                                => array(
                                                                                 'title' => 'Hardware Store'),                     
                                                            'HobbyShop'            
                                                                                => array(
                                                                                 'title' => 'Hobby Shop'),                     
                                                            'HomeGoodsStore'            
                                                                                => array(
                                                                                 'title' => 'Home Goods Store'),
                                                            'JewelryStore'            
                                                                                => array(
                                                                                 'title' => 'Jewelry Store'),                     
                                                            'LiquorStore'            
                                                                                => array(
                                                                                 'title' => 'Liquor Store'),
                                                            'MensClothingStore'            
                                                                                => array(
                                                                                 'title' => 'Mens Clothing Store'),
                                                            'MobilePhoneStore'            
                                                                                => array(
                                                                                 'title' => 'Mobile Phone Store'),
                                                            'MovieRentalStore'            
                                                                                => array(
                                                                                 'title' => 'Movie Rental Store'),
                                                            'MusicStore'            
                                                                                => array(
                                                                                 'title' => 'Music Store'),
                                                            'OfficeEquipmentStore'            
                                                                                => array(
                                                                                 'title' => 'Office Equipment Store'),
                                                            'OutletStore'            
                                                                                => array(
                                                                                 'title' => 'Outlet Store'),
                                                            'PawnShop'            
                                                                                => array(
                                                                                 'title' => 'Pawn Shop'),
                                                            'PetStore'            
                                                                                => array(
                                                                                 'title' => 'Pet Store'),                     
                                                            'ShoeStore'            
                                                                                => array(
                                                                                 'title' => 'Shoe Store'),                     
                                                            'SportingGoodsStore'            
                                                                                => array(
                                                                                 'title' => 'Sporting Goods Store'),                     
                                                            'TireShop'            
                                                                                => array(
                                                                                 'title' => 'Tire Shop'),                    
                                                            'ToyStore'            
                                                                                => array(
                                                                                 'title' => 'Toy Store'),                    
                                                                                 
                                                            'WholesaleStore'            
                                                                                => array(
                                                                                 'title' => 'Wholesale Store'),                     
                                                                                                                                                          
                                                            )
                                                ),
                'TelevisionStation'              
                                            => array(
                                                'parent'    => false, 
                                                'title'     => 'Television Station'),                                            
                'TouristInformationCenter'              
                                            => array(
                                                'parent'    => false, 
                                                'title'     => 'Tourist Information Center'),
                'TravelAgency'              
                                            => array(
                                                'parent'    => false, 
                                                'title'     => 'Travel Agency'),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
        );
        return $bunsiess_type;
        
    }
    
    
}
?>