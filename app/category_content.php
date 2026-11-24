<?php
/* Buying guide text for category pages, so no category page is thin.

   Three layers of hand-written text, combined by category_guide_html():
     - a short overview of each main category        (category_topic_overviews)
     - an overview, three buying checks and one question for each sub category   (category_packs)
     - one line on what each sub sub category is and what to check               (category_leaf_notes)
   plus fixed text about how buying on SaleBari works. No prices, no brand claims, no statistics.
   A category with no entry still gets a full page from the generic parts. */

function category_topic_overviews(): array
{
    return [
        'car-bike' => 'Car & Bike brings together accessories and care products for cars and motorcycles, three-wheelers such as CNG autos and auto rickshaws, commercial vehicles such as trucks, buses, tractors and boats, and vehicle rental services such as pickups and ambulances. Buyers here are usually motorists and drivers looking for parts and gear that fit their vehicle, or owners and operators looking for a vehicle for work.',
        'real-estate' => 'Real Estate covers flats and apartments, land and plots, commercial space, sanitary ware and construction material. It serves people buying a home or an investment, owners building on their own land, and shop owners looking for space. Property is the largest purchase most people make, so this section pairs listings with buying guides, calculators and location pages for Dhaka, Chittagong and Feni.',
        'agro' => 'Agro lists livestock, fish, poultry and birds for farming, breeding, the table and hobby keeping. Buyers include farmers stocking a farm, families buying animals for an occasion, and traders. Because these are living animals, the health of the animal and the honesty of the seller matter more than the headline price.',
        'travels' => 'Travels lists tickets and travel services: air, bus, train and ship tickets, hotel booking, tour packages, Umrah and Hajj packages, visa processing and doctor appointments. These are services booked through agents, so the written details, the payment trail and the agent\'s credibility are what protect you.',
        'jobs' => 'Jobs is where employers and recruiters advertise vacancies and where people look for work in Bangladesh. A genuine employer never asks a job seeker to pay to get a job, so treat any request for money, a deposit or a processing fee as a warning sign and check the employer before you share personal documents.',
        'household' => 'Household covers furniture, office furniture, bedding, decoration, cleaning products, pest control, kitchenware, stationery and bathroom accessories for homes, shops and offices. Most buyers are furnishing a room, replacing an item or setting up a new home or workplace, where size, material and delivery matter as much as the price.',
        'electronics' => 'Electronics covers cooling and heating, TVs and video, home appliances, cameras and accessories, mobile phones and accessories, telephony, audio, portable media and radio. Spec sheets can be confusing, so the useful questions are whether the product is original, what warranty it carries and whether it suits the space, the power supply and the way you will use it.',
    ];
}

function category_packs(): array
{
    return [
        'car-bike/accessories' => ['a' => 'Car accessories range from dash cameras and diagnostic scanners to engine oil and cosmetic care products. Buyers usually want items that protect the car, make driving safer or keep running costs down.',
            't' => ['Check that the product fits your car\'s make, model and year before you buy.', 'Ask for the brand, the batch or warranty details and whether the product is original or a local copy.', 'For anything that connects to the car, ask how it is installed and who fits it.'],
            'q' => 'Will a car accessory fit every car?', 'r' => 'Not always. Many accessories are made for particular models, engines or connectors, so share your car\'s make, model and year with the seller and ask them to confirm fit before paying.'],
        'car-bike/bike-accessories' => ['a' => 'Bike accessories cover safety gear and wear parts such as helmets and tyres for motorcycles and scooters.',
            't' => ['Match the tyre size and the helmet size to your bike and your head, using the size printed on the product.', 'For safety gear, ask whether it meets a recognised safety standard and look for a certification mark.', 'Check the manufacturing date on tyres, because rubber ages even when unused.'],
            'q' => 'How do I choose the right helmet size?', 'r' => 'Measure around your head just above the eyebrows and compare it with the seller\'s size chart. A helmet should fit snugly without pressure points and should not move when you shake your head.'],
        'car-bike/three-wheeler' => ['a' => 'Three-wheelers such as CNG autos and auto rickshaws carry passengers and goods. Buyers range from drivers buying a first vehicle to owners adding to a fleet.',
            't' => ['Check the registration certificate, the fitness certificate and the tax token, and that the engine and chassis numbers match the papers.', 'Ask for the service history and see the vehicle run: starting, braking, steering and the fuel system.', 'Ask which licence or route requirements apply and whether they transfer to you.'],
            'q' => 'What papers should I check for a used three-wheeler?', 'r' => 'Ask to see the registration certificate, the fitness certificate, the road tax token and the insurance, and compare the engine and chassis numbers on the papers with those on the vehicle. Confirm the transfer process with the authority before you pay in full.'],
        'car-bike/commercial-vehicle' => ['a' => 'Commercial vehicles include trucks, buses, tractors and boats used for carrying goods and passengers or for work on farms and rivers.',
            't' => ['Check the registration, fitness and insurance papers and the vehicle\'s load or passenger rating.', 'Ask for maintenance records and have a mechanic inspect the engine, gearbox, brakes and tyres.', 'For boats, ask for the build details, the engine and any registration or licence that applies.'],
            'q' => 'Should I get a mechanic to inspect a used commercial vehicle?', 'r' => 'Yes. A vehicle that works hard wears quickly, and an independent mechanic can spot engine, gearbox, brake and chassis problems that are hard to see. Ask the seller to allow an inspection before you pay.'],
        'car-bike/rental' => ['a' => 'Rental listings offer vehicles and related services for a day, a trip or a longer period, such as pickups and ambulances.',
            't' => ['Ask for the full price: per day or per kilometre, the driver, fuel, tolls and waiting charges.', 'Check the vehicle and the driver\'s licence, and ask what the insurance covers.', 'Confirm the pick-up time and place and the cancellation terms in writing; a WhatsApp message is enough.'],
            'q' => 'What should I confirm before booking a rental vehicle?', 'r' => 'Confirm the total price and what it includes, the pick-up time and place, the vehicle type, the driver\'s licence and the cancellation terms. Keep the messages as a record.'],

        'real-estate/apartment' => ['a' => 'Apartment listings include flats for sale in different areas and sizes. Prices depend on the area, floor, size, age of the building and facilities.',
            't' => ['Compare flats by price per square foot, using the same kind of area (net or super built-up) for each.', 'Verify the deed, the land share, the mutation and the approved plan before you pay.', 'Visit in person and check the building, the lift, the parking and the utilities.'],
            'q' => 'Where can I learn how to buy a flat safely?', 'r' => 'Read the buying guides on how to buy a flat, the documents to check and the costs beyond the price, and use the property pages for Dhaka, Chittagong and Feni to see flats by area and size.'],
        'real-estate/land' => ['a' => 'Land and plot listings range from small residential plots to larger holdings. Sizes are given in katha, decimal (shotangsho), bigha or square feet.',
            't' => ['Check the khatian, the deed and the mutation, and match the dag number on the site.', 'Confirm the unit used (katha, decimal or bigha) and the local measure, then work out the price per unit.', 'Ask a lawyer to search for disputes, mortgages and court cases before you pay.'],
            'q' => 'How do I convert katha, decimal and bigha?', 'r' => 'Use the land size converter. In the standard Dhaka measure 1 katha is 720 square feet and 1 bigha is 20 katha, but the measure differs by region, so check what your deed says.'],
        'real-estate/commercial-space' => ['a' => 'Commercial space listings include shops, offices and showrooms. Location, footfall, the floor and the building\'s approvals matter more than size alone.',
            't' => ['Check that the building\'s approved use allows commercial activity and that its plan is approved.', 'Ask about the service charge, parking, lift and generator, and the rules for signs and opening hours.', 'Check the title papers and any lease or tenancy already on the space.'],
            'q' => 'What should I check before buying a shop or office?', 'r' => 'Check the ownership papers, the approved plan and permitted use, any tenant already in the space, the service charge and the access for customers. Visit at the busiest time of day.'],
        'real-estate/sanitary' => ['a' => 'Sanitary ware covers commodes, basins and taps for bathrooms and kitchens.',
            't' => ['Check the size, the drain position and the mounting type against your bathroom.', 'Ask about the material, the finish and the warranty, and keep the invoice.', 'Look at the box for chips or cracks before the delivery person leaves.'],
            'q' => 'How do I pick a commode for my bathroom?', 'r' => 'Measure the distance from the wall to the drain and check whether your drain is a floor or a wall outlet. Then choose the flush type and size to match, and confirm the fitting method with the seller.'],
        'real-estate/construction-material' => ['a' => 'Construction material listings cover bricks, cement, rod (steel reinforcement), sand, stone and construction equipment.',
            't' => ['Ask for the brand, the grade and the test certificate, and compare them with what your engineer specified.', 'Check the quantity, the unit (per bag, per tonne, per thousand) and the delivery cost before comparing prices.', 'Inspect a delivered sample before you accept the full load.'],
            'q' => 'Why do material prices differ between sellers?', 'r' => 'Differences come from the brand, the grade, the unit of sale, the delivery distance and the amount you buy. Compare the same grade in the same unit with delivery included.'],

        'agro/livestock' => ['a' => 'Livestock listings include cattle, goats and buffalo for farming, breeding or occasions such as Eid.',
            't' => ['See the animal in person and check its health, age, teeth and the way it moves.', 'Ask about vaccination and feed, and have a veterinarian check a costly animal.', 'Agree the price method (by weight or by head) and how the animal will be transported.'],
            'q' => 'How do I check the health of an animal before buying?', 'r' => 'Look for bright eyes, a clean nose, normal breathing, steady walking and a good appetite. Ask about vaccinations and have a veterinarian check an expensive animal.'],
        'agro/fish' => ['a' => 'Fish listings include farm fish such as rui, katla, tilapia and pangas, sold fresh or as fingerlings for stocking ponds.',
            't' => ['Ask whether the fish is live, fresh or frozen, the size or weight grade and the price per kilogram.', 'Check freshness: clear eyes, red gills, firm flesh and no strong smell.', 'For fingerlings, ask the age, the source hatchery and any survival guarantee.'],
            'q' => 'How can I tell if fish is fresh?', 'r' => 'Fresh fish has clear eyes, bright red gills, firm flesh and a clean smell. Ask when it was caught or harvested and how it has been kept since.'],
        'agro/poultry' => ['a' => 'Poultry listings cover chicken and ducks, as chicks, layers, broilers or eggs, for farming or the table.',
            't' => ['Ask the age, the breed, the vaccination record and the hatchery or farm.', 'Check the birds for activity, clean eyes and no breathing noise.', 'Ask the weight, the count and the delivery arrangements.'],
            'q' => 'What should I ask a poultry seller?', 'r' => 'Ask the breed, the age, the vaccinations, the source farm, the price per bird or kilogram and when you can collect. Look at the flock yourself before a large order.'],
        'agro/birds' => ['a' => 'Bird listings include pigeons and other permitted birds kept as pets or as a hobby.',
            't' => ['Make sure the species is legal to keep and trade, and ask the seller to confirm.', 'Check the bird\'s health: alert, clean eyes, normal droppings and smooth feathers.', 'Ask about age, diet and care needs.'],
            'q' => 'Can I buy any bird?', 'r' => 'No. Some wild species are protected by law. Buy only birds that are legal to keep and sell, and ask the seller to confirm the species.'],

        'travels/air-ticket' => ['a' => 'Air ticket listings are for booking domestic and international flights through agents.',
            't' => ['Confirm the airline, the dates, the baggage allowance and the fare rules before paying.', 'Ask for the e-ticket and check the passenger name against the passport.', 'Pay an agent you can trace and keep the payment receipt.'],
            'q' => 'How do I check that my ticket is genuine?', 'r' => 'Ask for the e-ticket and the booking reference, then check them on the airline\'s website or app. The passenger name must match the passport exactly.'],
        'travels/bus-ticket' => ['a' => 'Bus ticket listings help you book seats on intercity routes.',
            't' => ['Confirm the operator, the route, the departure point, the time and the seat number.', 'Ask about the bus type and the cancellation rules.', 'Keep the ticket or confirmation message and arrive early at the counter.'],
            'q' => 'Can I cancel a bus ticket?', 'r' => 'It depends on the operator. Ask for the cancellation and refund rules before you pay and get them in writing.'],
        'travels/tour-package' => ['a' => 'Tour package listings offer trips within Bangladesh and abroad that bundle transport, stay and sightseeing.',
            't' => ['Ask for a written itinerary that lists what is included and what is not.', 'Check the hotel, the transport, the guide and the group size.', 'Ask for the payment schedule and the refund terms.'],
            'q' => 'What should a good tour package include in writing?', 'r' => 'It should state the dates, the places, the hotel category, the transport, the meals, the guide, the total price, what is not included and the cancellation rules.'],
        'travels/umrah-package' => ['a' => 'Umrah package listings are for pilgrims travelling to Makkah and Madinah through travel agencies.',
            't' => ['Use an agency that holds the proper authorisation, and ask to see it.', 'Get the package in writing: flights, hotel distance from the Haram, visa, transport and dates.', 'Pay by traceable methods and keep every receipt.'],
            'q' => 'How do I choose an Umrah agency?', 'r' => 'Check that the agency is authorised, ask for references from earlier pilgrims, read the written package carefully and avoid paying everything in cash up front.'],
        'travels/hajj-package' => ['a' => 'Hajj package listings are for pilgrims and are offered through registered agencies.',
            't' => ['Hajj is arranged through approved channels, so confirm that the agency is registered with the authority.', 'Get the full package, the costs and the dates in writing.', 'Keep copies of your passport, your receipts and the agreement.'],
            'q' => 'How can I check that a Hajj agency is registered?', 'r' => 'Ask the agency for its registration details and confirm them with the relevant government authority. Be careful with any agency that cannot show them.'],
        'travels/hotel-booking' => ['a' => 'Hotel booking listings help you reserve rooms in cities and tourist areas.',
            't' => ['Confirm the room type, the dates, the price including taxes and the check-in time.', 'Ask about the cancellation policy and the payment method.', 'Get a booking confirmation that shows the hotel\'s name and address.'],
            'q' => 'How do I confirm that a hotel booking is real?', 'r' => 'Ask for a written confirmation, then call the hotel to verify your name and dates. Avoid paying the full amount to an unknown account without confirmation.'],
        'travels/visa-processing' => ['a' => 'Visa processing listings are for agencies that help prepare and submit visa applications.',
            't' => ['Remember that only the embassy decides: no agent can guarantee a visa.', 'Ask the fees clearly: the service charge, the embassy fee and the courier.', 'Check which documents you must provide and keep copies.'],
            'q' => 'Can an agent guarantee my visa?', 'r' => 'No. The embassy or consulate makes the decision. Be careful with anyone who promises a guaranteed visa or asks for large payments before submitting your application.'],
        'travels/doctor-appointment' => ['a' => 'Doctor appointment listings help you book consultations with doctors.',
            't' => ['Confirm the doctor\'s name, specialty, chamber address, date and time.', 'Ask the fee and whether it covers repeat visits.', 'Bring your earlier reports and prescriptions.'],
            'q' => 'How should I prepare for an appointment?', 'r' => 'Bring your earlier reports, your prescriptions and a list of your symptoms and medicines. Confirm the time and the fee the day before.'],
        'travels/train-ticket' => ['a' => 'Train ticket listings help with seat bookings on rail routes.',
            't' => ['Confirm the train, the class, the date, the departure time and the station.', 'Check the passenger names and the ticket rules.', 'Keep the ticket and an ID with you, and buy early on busy days.'],
            'q' => 'Do train tickets need ID?', 'r' => 'Rail tickets generally need a valid identity for the passenger, so keep an ID with you and check the current rules with the railway or your agent.'],
        'travels/saint-martin-ship-ticket' => ['a' => 'Saint Martin ship ticket listings are for the sea trip to Saint Martin\'s Island.',
            't' => ['Confirm the ship, the departure day and time and the cabin or seat class.', 'Check the weather and whether sailing is running that day.', 'Ask about the baggage rules and the return ticket.'],
            'q' => 'What if the ship does not sail because of the weather?', 'r' => 'Sailings can be cancelled for weather or sea conditions. Before you pay, ask how a cancelled sailing is handled and whether you get a refund or a new date.'],

        'household/furniture' => ['a' => 'Furniture listings cover beds, tables, chairs, sofas, wardrobes and more for homes.',
            't' => ['Measure your room and the doorways before ordering large pieces.', 'Ask about the material (solid wood, engineered wood or metal) and the finish.', 'Inspect joints and drawers, and ask about warranty, delivery and assembly.'],
            'q' => 'How can I tell solid wood from engineered wood?', 'r' => 'Solid wood shows continuous grain and feels heavy, while engineered wood or board often shows a visible edge layer. Ask the seller to name the material and put it on the receipt.'],
        'household/office-furniture' => ['a' => 'Office furniture includes tables, chairs and display racks for workplaces and shops.',
            't' => ['Check the dimensions against your space and the number of people who will use it.', 'For chairs, look at the seat, the back support and any adjustable parts.', 'Ask about the load rating and the warranty.'],
            'q' => 'What should I look for in an office chair?', 'r' => 'Look for a supportive back, an adjustable seat height, a firm base and wheels that roll smoothly. Sit in it for a few minutes if you can, and ask about the warranty.'],
        'household/bedding' => ['a' => 'Bedding covers mattresses, sheets, pillows, blankets and mosquito nets.',
            't' => ['Check the mattress size against your bed frame, including the thickness.', 'Ask about the fabric, the filling and the care instructions.', 'Ask whether a trial or a return is possible.'],
            'q' => 'How do I choose a mattress?', 'r' => 'Choose by size, firmness and material. Medium-firm suits many people, but lie on it if you can, and ask about the warranty and the return terms.'],
        'household/decoration' => ['a' => 'Decoration listings cover curtains, mirrors, doors, tiles, floor mats, showpieces and interior design services.',
            't' => ['Measure the space or the window and order a little extra for tiles and fabric.', 'Ask for a sample or a clear photo of the actual colour, since screens change colours.', 'For interior design, ask to see earlier work and get the scope and price in writing.'],
            'q' => 'How much extra tile should I order?', 'r' => 'Order a little more than the measured area to cover cutting and breakage, and keep a spare box for later repairs, because the same batch may not be available again.'],
        'household/furniture-accessories' => ['a' => 'Furniture accessories are the fittings and extras that go with furniture, such as handles, hinges, runners and covers.',
            't' => ['Check the size, the screw pattern and the finish against your furniture.', 'Buy a complete set from the same batch so the finish matches.', 'Ask about the load rating for hinges and runners.'],
            'q' => 'How do I find a fitting that matches my furniture?', 'r' => 'Measure the existing part, note the hole spacing and the finish, and send the seller a photo. A seller can then confirm a match before you pay.'],
        'household/cleaner' => ['a' => 'Household cleaner listings include floor and glass cleaners, mops, hose pipes, baskets and air fresheners.',
            't' => ['Check the quantity and the strength: some products must be diluted.', 'Read what surfaces the product is safe for before you use it.', 'Keep cleaning chemicals away from children and do not mix them.'],
            'q' => 'Can I mix cleaning products?', 'r' => 'No. Mixing some cleaning chemicals can release harmful fumes. Use one product at a time, follow the label and keep the room ventilated.'],
        'household/pest-control' => ['a' => 'Pest control listings include mosquito killers and professional pest control services for homes and offices.',
            't' => ['Ask which pests the product or service treats and how long it works.', 'For services, ask what chemicals are used and the precautions for children, pets and food.', 'Get the visit schedule and any guarantee in writing.'],
            'q' => 'Is pest control safe for children and pets?', 'r' => 'It can be if the provider uses suitable products and you follow the precautions. Ask which chemicals are used, how long to keep the room empty and when food areas can be used again.'],
        'household/kitchenware' => ['a' => 'Kitchenware covers cookware, crockery, knives, bottles and tools for cooking and serving.',
            't' => ['Ask what the cookware is made of and whether it works on your stove type.', 'Check the thickness, the handles and the lid fit.', 'Ask about the care instructions and whether it is dishwasher safe.'],
            'q' => 'Will this cookware work on my stove?', 'r' => 'Gas stoves work with most cookware. Electric and induction stoves need a flat base and, for induction, a magnetic base. Ask the seller to confirm for your stove.'],
        'household/stationery-craft' => ['a' => 'Stationery and craft listings cover notebooks, pens, tape, staplers, wrapping paper and measuring tools.',
            't' => ['Check the quantity per pack and the size of the item.', 'Ask about the paper weight or the ink type where it matters.', 'For bulk orders, ask for a sample first.'],
            'q' => 'Can I buy stationery in bulk?', 'r' => 'Many sellers offer a lower price per piece for bulk orders. Ask for a quote, confirm the quantity and the delivery cost, and request a sample for a large order.'],
        'household/bathroom-accessories' => ['a' => 'Bathroom accessories include fittings and add-ons such as toilet seats.',
            't' => ['Match the fitting to the shape and size of your fixture.', 'Check the material and the hinge or fixing parts.', 'Ask how it is installed and whether the fixings are included.'],
            'q' => 'How do I choose a toilet seat that fits?', 'r' => 'Measure the length and width of your bowl and the distance between the mounting holes, then compare with the seat\'s listed size. Ask the seller to confirm the fit.'],

        'electronics/cooling-heating' => ['a' => 'Cooling and heating covers air conditioners, fans, coolers, heaters, purifiers and related accessories.',
            't' => ['Match the capacity to the room: a unit that is too small struggles and one that is too large wastes electricity.', 'Check the power rating, the energy efficiency and the warranty, including the compressor.', 'Ask about installation, the pipe length included and after-sales service.'],
            'q' => 'How do I choose the right AC size?', 'r' => 'Capacity depends on the room size, the ceiling height, the sunlight and the number of people. Use the AC ton calculator in this section as a guide, and ask the seller or a technician to confirm.'],
        'electronics/tv-video' => ['a' => 'TV and video covers televisions, set-top and streaming devices, game consoles and accessories.',
            't' => ['Choose the screen size by viewing distance and the space on your wall or stand.', 'Check the resolution, the ports you need and the smart features.', 'Ask about the warranty, the panel warranty and whether delivery includes mounting.'],
            'q' => 'What TV size suits my room?', 'r' => 'It depends on how far you sit. A larger screen suits a longer viewing distance. Use the TV size calculator in this section, and check that the TV fits your wall or stand.'],
        'electronics/home-appliance' => ['a' => 'Home appliances cover kitchen and household machines such as refrigerators, washing machines, ovens, blenders and water filters.',
            't' => ['Check the capacity against your household size and the space where it will stand.', 'Check the power rating and the voltage, and ask about the warranty on the motor or compressor.', 'Ask whether the seller offers installation and where the service centre is.'],
            'q' => 'How do I check that an appliance is original?', 'r' => 'Ask for the brand\'s warranty card and the invoice, check the serial number on the product and the box, and compare the model number with the brand\'s official specifications.'],
        'electronics/camera-photo' => ['a' => 'Camera and photo listings include DSLR and mirrorless cameras, action and video cameras, drones, binoculars and telescopes.',
            't' => ['For a used camera, ask for the shutter count and check the sensor, the lens mount and the screen.', 'Confirm what is in the box: battery, charger, strap, memory card and lens.', 'For drones, ask about the flight time, the range and the rules for flying where you live.'],
            'q' => 'What should I check on a used camera?', 'r' => 'Ask for the shutter count, check the sensor for dust or marks, test the buttons, the screen and the autofocus, and make sure the lens is free from fungus and scratches.'],
        'electronics/camera-accessories' => ['a' => 'Camera accessories cover lenses, flashes, lights, batteries, chargers, memory cards, tripods, bags and cleaning gear.',
            't' => ['Check that the item fits your camera model and mount.', 'For memory cards, check the capacity, the speed class and that it is genuine.', 'For batteries and chargers, ask whether they are original.'],
            'q' => 'How do I know a lens fits my camera?', 'r' => 'Check the lens mount type (for example, the brand\'s mount name) and whether your camera body is full frame or crop sensor. Ask the seller to confirm compatibility for your model.'],
        'electronics/mobile' => ['a' => 'Mobile listings include phones for different budgets, new and used.',
            't' => ['Check the IMEI number and that the phone is not blocked or reported lost.', 'Ask whether it is an official or an unofficial import, and what warranty it has.', 'Check the battery health, the screen, the cameras and the charging port before you pay.'],
            'q' => 'How do I check a phone\'s IMEI?', 'r' => 'Dial *#06# on the phone to see its IMEI, and compare it with the number on the box and the invoice. Check that the phone is registered and not blocked before you pay.'],
        'electronics/mobile-accessories' => ['a' => 'Mobile accessories cover chargers, cables, power banks, cases, screen protectors, holders and more.',
            't' => ['Check that the item suits your phone model and the connector type.', 'For chargers and power banks, check the output rating and whether it is original.', 'Be careful with very cheap charging gear, because poor quality can damage a phone or battery.'],
            'q' => 'Is a cheap charger safe for my phone?', 'r' => 'Poor-quality chargers and power banks can overheat and damage a battery. Choose a recognised brand with a clear rating, and avoid unmarked products.'],
        'electronics/telephony' => ['a' => 'Telephony covers desk phones, IP phones, PABX systems, fax machines and walkie-talkies for offices and homes.',
            't' => ['Match the system to the number of lines and extensions you need.', 'Check compatibility with your line or network.', 'Ask about the warranty, installation and support.'],
            'q' => 'What is a PABX system?', 'r' => 'A PABX is an internal phone exchange that connects the extensions in an office to each other and to outside lines. Choose one by the number of lines and extensions you need.'],
        'electronics/home-stage-audio' => ['a' => 'Home and stage audio covers speakers, amplifiers and sound systems for the home, events and stages.',
            't' => ['Check the power rating in watts and the impedance against your amplifier.', 'Listen before you buy if you can, at the volume you plan to use.', 'Ask about the warranty and whether cables and stands are included.'],
            'q' => 'How do I pick speakers for a room or hall?', 'r' => 'Match the speaker power and the room size, and check that the speaker impedance suits the amplifier. Listening in a similar space gives the best idea of the sound.'],
        'electronics/portable-media' => ['a' => 'Portable media covers voice recorders, ebook readers, MP3 players, calculators and related devices.',
            't' => ['Check the storage, the battery life and the file formats supported.', 'Ask what accessories and cables come in the box.', 'Check the display and buttons on a used device.'],
            'q' => 'What should I check on a voice recorder?', 'r' => 'Check the recording quality, the storage, the battery life and whether it can transfer files to your computer or phone.'],
        'electronics/radio' => ['a' => 'Radio listings cover portable and home radios.',
            't' => ['Check the bands supported (FM, AM, shortwave) and the reception.', 'Check the power source: batteries, mains or both.', 'Ask about the warranty and the condition of the antenna.'],
            'q' => 'Which radio bands do I need?', 'r' => 'FM is common for local stations. If you want to listen to distant stations, look for a model with AM or shortwave as well.'],
    ];
}

/** One line on each sub sub category: what it is and what to check. Keys are the category path. */
function category_leaf_notes(): array
{
    return [
        // car & bike
        'car-bike/accessories/dashcam' => 'A dashcam records the road ahead, and sometimes inside the car, as evidence in an accident. Check the video quality, night recording, storage and loop recording.',
        'car-bike/accessories/engine-oil' => 'Engine oil lubricates and cools the engine. Choose the grade and specification your owner\'s manual recommends, and buy sealed containers from a trusted seller.',
        'car-bike/accessories/scanner' => 'A car scanner reads fault codes from the engine computer. Check that it supports your car\'s protocol and connector and that the software is easy to use.',
        'car-bike/accessories/scratch-remover' => 'Scratch removers polish out light scratches on paint. Check which scratch depth the product handles and whether it suits your paint finish.',
        'car-bike/bike-accessories/motorcycle-helmet' => 'A helmet protects your head in a crash. Choose the right size, a secure strap and a certified build rather than the lowest price.',
        'car-bike/bike-accessories/motorcycle-tyre' => 'Tyres are your bike\'s contact with the road. Match the size, load and speed rating on the sidewall, and check the manufacturing date.',
        'car-bike/commercial-vehicle/boat' => 'Boats are listed for fishing, transport and river work. Check the hull, the engine, the capacity and any registration or licence that applies.',
        'car-bike/commercial-vehicle/bus' => 'Buses are bought for passenger service. Check the seating, the engine hours or mileage, the route permit needs and the papers.',
        'car-bike/commercial-vehicle/tractor' => 'Tractors power farm work. Check the horsepower, the hours of use, the hydraulics and the attachments that come with it.',
        'car-bike/commercial-vehicle/truck' => 'Trucks carry goods. Check the load rating, the engine and gearbox condition, the body and the registration and fitness papers.',
        'car-bike/rental/ambulance-service' => 'Ambulance services provide patient transport. Ask about the equipment on board, the response time, the area covered and the charges per trip or per kilometre.',
        'car-bike/rental/pickup-rental' => 'Pickup rental suits moving goods. Confirm the load capacity, the price per trip or day, the driver and whether loading help is included.',
        'car-bike/three-wheeler/auto-rickshaw' => 'Auto rickshaws are small passenger vehicles. Check the engine condition, the battery or fuel system, the body and the papers.',
        'car-bike/three-wheeler/cng' => 'CNG three-wheelers run on compressed natural gas. Check the cylinder certificate and test date, the kit condition and the registration papers.',
        // real estate
        'real-estate/construction-material/brick' => 'Bricks are the basic wall material. Check the type, the strength, the size consistency and the price per thousand, including delivery.',
        'real-estate/construction-material/cement' => 'Cement binds concrete and mortar. Check the brand, the type, the manufacturing date and that the bags are sealed and dry.',
        'real-estate/construction-material/equipment' => 'Construction equipment ranges from mixers to scaffolding. Check the capacity, the condition, the spare parts and whether rental is offered.',
        'real-estate/construction-material/rod' => 'Rod is the steel reinforcement in concrete. Check the grade, the diameter, the bundle weight and the test certificate against your engineer\'s design.',
        'real-estate/construction-material/sand' => 'Sand is used in concrete and plaster. Check the type (coarse or fine), the cleanliness and how the quantity is measured.',
        'real-estate/construction-material/stone' => 'Stone chips are used in concrete. Check the size grade, the hardness and the cleanliness, and how the load is measured.',
        'real-estate/sanitary/basin' => 'A basin is the washbasin in a bathroom. Check the size, the mounting type, the drain position and the material.',
        'real-estate/sanitary/commode' => 'A commode is the toilet fixture. Check the trap type, the flush, the size, the seat and the fitting method.',
        'real-estate/sanitary/water-tap' => 'Water taps control water flow. Check the material, the finish, the thread size and the type (basin, kitchen, shower).',
        // agro
        'agro/birds/other-permitted-birds' => 'This lists legally permitted birds other than pigeons. Confirm the species is legal to keep and ask about age, diet and health.',
        'agro/birds/pigeon' => 'Pigeons are kept as pets and for hobby racing. Ask the breed, the age, the health and the diet, and see the birds yourself.',
        'agro/fish/katla' => 'Katla is a fast-growing carp raised in ponds. Ask the size, whether it is live or fresh and the price per kilogram.',
        'agro/fish/other-fish' => 'This lists other farm and river fish. Ask the species, the size grade, the source and how it was kept.',
        'agro/fish/pangas' => 'Pangas is a widely farmed catfish. Ask the size grade, the farm source and the price per kilogram, and check freshness.',
        'agro/fish/rui' => 'Rui is a popular carp. Ask the size, whether it is live or fresh, and the price per kilogram.',
        'agro/fish/tilapia' => 'Tilapia is a hardy farmed fish. Ask the size, the source and the price per kilogram, and check freshness.',
        'agro/livestock/buffalo' => 'Buffalo are kept for milk, work and meat. Check the age, the health, the milk yield if relevant and the papers or history.',
        'agro/livestock/cow' => 'Cows are bought for milk, breeding or meat. Check the age, the health, the breed and, for dairy cows, the milk yield.',
        'agro/livestock/goat' => 'Goats are bought for meat, milk and breeding. Check the age, the health, the breed and the price method.',
        'agro/poultry/chicken' => 'Chickens are sold as chicks, layers or broilers. Ask the breed, the age, the vaccinations and the source farm.',
        'agro/poultry/duck' => 'Ducks are raised for eggs and meat. Ask the breed, the age, the vaccinations and how they have been kept.',
        // travels
        'travels/doctor-appointment/indian-doctor-appointment' => 'This helps arrange appointments with doctors in India. Confirm the doctor, the hospital, the date, the fee and what the service charge covers.',
        // household
        'household/bathroom-accessories/toilet-seat' => 'A toilet seat replaces the seat on a toilet. Measure your bowl and the mounting holes, and check the material and the hinges.',
        'household/bedding/bed-sheet' => 'Bed sheets cover the mattress. Check the size, the fabric and thread quality, and the care instructions.',
        'household/bedding/blanket' => 'Blankets keep you warm. Check the size, the material, the weight and how to wash it.',
        'household/bedding/cushion' => 'Cushions add comfort and style. Check the size, the filling, the cover fabric and whether the cover is removable.',
        'household/bedding/mattress' => 'A mattress affects how well you sleep. Check the size, the firmness, the material and the warranty.',
        'household/bedding/mosquito-net' => 'Mosquito nets keep insects off while you sleep. Check the size against your bed, the mesh and how it hangs.',
        'household/bedding/pillow' => 'Pillows support your head and neck. Check the size, the filling, the firmness and the cover.',
        'household/bedding/sofa-foam' => 'Sofa foam is the cushioning inside a sofa. Check the thickness, the density and the size cut to your seat.',
        'household/cleaner/air-freshener' => 'Air fresheners scent a room. Check the fragrance type, the quantity and whether it suits people with allergies.',
        'household/cleaner/basket' => 'Baskets store laundry and household items. Check the size, the material and the strength.',
        'household/cleaner/floor-cleaner' => 'Floor cleaners clean tiles and floors. Check which surfaces it is safe for, the dilution and the quantity.',
        'household/cleaner/glass-cleaner' => 'Glass cleaners clean windows and mirrors. Check the quantity, whether it leaves streaks and the spray type.',
        'household/cleaner/hose-pipe' => 'Hose pipes carry water for washing and gardens. Check the length, the diameter, the material and the connectors.',
        'household/cleaner/mop' => 'Mops clean floors. Check the type, the head material, the handle length and whether the head is replaceable.',
        'household/decoration/curtain' => 'Curtains control light and privacy. Measure the window, and check the fabric, the lining and how it hangs.',
        'household/decoration/decor-accessories' => 'Decor accessories finish a room. Check the size, the material and a photo of the real item.',
        'household/decoration/door' => 'Doors suit different rooms and budgets. Check the material, the size of the frame, the thickness and the fittings.',
        'household/decoration/floor-mat' => 'Floor mats protect floors and add comfort. Check the size, the material, the non-slip backing and the care.',
        'household/decoration/interior-design' => 'Interior design services plan and fit out rooms. Ask to see earlier work, and get the scope, timeline and price in writing.',
        'household/decoration/mirror' => 'Mirrors add light and space. Check the size, the thickness, the frame and how it is hung.',
        'household/decoration/organizer' => 'Organizers keep things tidy. Check the size, the material and how many compartments it has.',
        'household/decoration/showpiece' => 'Showpieces decorate shelves and tables. Check the size, the material and ask for a real photo.',
        'household/decoration/tiles' => 'Tiles cover floors and walls. Check the size, the thickness, the finish, the batch and order a little extra.',
        'household/furniture/air-bed' => 'An air bed is an inflatable mattress for guests and travel. Check the size, the pump and the material strength.',
        'household/furniture/almirah' => 'An almirah is a storage cupboard. Check the material, the size, the shelves, the lock and the door fit.',
        'household/furniture/bed' => 'Beds come in many sizes and styles. Check the frame size against your mattress, the material and the storage.',
        'household/furniture/bedside-table' => 'Bedside tables sit next to the bed. Check the height, the drawers and the material.',
        'household/furniture/center-table' => 'Center tables sit in the middle of a living room. Check the size, the height and the material.',
        'household/furniture/dining-chair' => 'Dining chairs seat people at the table. Check the comfort, the height, the material and the number in the set.',
        'household/furniture/dining-table' => 'Dining tables seat the family. Check the size, the number of seats, the material and the strength of the legs.',
        'household/furniture/divan' => 'A divan is a bed or couch base, often with storage. Check the size, the storage and the material.',
        'household/furniture/dressing-table' => 'Dressing tables hold a mirror and storage. Check the size, the mirror quality and the drawers.',
        'household/furniture/furniture-set' => 'Furniture sets bundle matching pieces. Check what is in the set, the finish and the sizes.',
        'household/furniture/kitchen-furniture' => 'Kitchen furniture includes cabinets and shelves. Measure the space and check the material and water resistance.',
        'household/furniture/shelf' => 'Shelves store books and goods. Check the size, the load rating, the material and how it is fixed.',
        'household/furniture/shoe-rack' => 'Shoe racks keep footwear tidy. Check the number of pairs it holds, the size and the material.',
        'household/furniture/showcase' => 'Showcases display items behind glass. Check the size, the glass and the shelves.',
        'household/furniture/sofa-set' => 'Sofa sets furnish a living room. Check the size, the seating, the frame, the foam and the fabric.',
        'household/furniture/stool' => 'Stools give extra seating. Check the height, the material and the strength.',
        'household/furniture/trolley' => 'Trolleys move and store items. Check the size, the wheels and the load rating.',
        'household/furniture/wardrobe' => 'Wardrobes store clothes. Check the size, the doors, the shelves, the hanging space and the material.',
        'household/kitchenware/crockeries' => 'Crockery covers plates, bowls and serving sets. Check the material, the number of pieces and whether it is microwave safe.',
        'household/kitchenware/cup-mug' => 'Cups and mugs serve drinks. Check the size, the material and whether they are microwave or dishwasher safe.',
        'household/kitchenware/fry-pan' => 'A fry pan is used for frying and sautéing. Check the material, the coating, the size and the handle.',
        'household/kitchenware/kitchen-knife' => 'Kitchen knives cut food. Check the blade material, the handle and the balance.',
        'household/kitchenware/korai' => 'A korai is a deep pan for frying and curries. Check the material, the thickness, the size and the handles.',
        'household/kitchenware/pressure-cooker' => 'Pressure cookers cook food faster. Check the capacity, the material, the safety valve and the gasket.',
        'household/kitchenware/vegetable-cutter' => 'Vegetable cutters speed up chopping. Check the blades, the safety and how easy it is to clean.',
        'household/kitchenware/water-bottle' => 'Water bottles carry drinking water. Check the capacity, the material, the leak-proof lid and the insulation if needed.',
        'household/office-furniture/chair' => 'Office chairs support long sitting. Check the back support, the seat height, the base and the wheels.',
        'household/office-furniture/display-rack' => 'Display racks show goods in shops. Check the size, the number of shelves, the load rating and the material.',
        'household/office-furniture/office-table' => 'Office tables are work surfaces. Check the size, the drawers, the cable space and the material.',
        'household/pest-control/mosquito-killer' => 'Mosquito killers repel or kill mosquitoes. Check the type, the coverage area and the safety for children and pets.',
        'household/pest-control/pest-control-service' => 'Pest control services treat homes and offices. Ask about the pests covered, the chemicals used, the safety steps and a guarantee.',
        'household/stationery-craft/measuring-tape' => 'Measuring tapes measure length. Check the length, the units and how well it locks.',
        'household/stationery-craft/paper-notebook' => 'Notebooks are for writing and notes. Check the paper quality, the size and the number of pages.',
        'household/stationery-craft/pen' => 'Pens are for writing. Check the ink type, the tip size and the quantity per pack.',
        'household/stationery-craft/scotch-tape' => 'Scotch tape is for sealing and mending. Check the width, the length and the stickiness.',
        'household/stationery-craft/stapler' => 'Staplers fasten paper. Check the staple size, the sheet capacity and the build.',
        'household/stationery-craft/wrapping-paper' => 'Wrapping paper covers gifts. Check the size, the quality and the design.',
        // electronics
        'electronics/camera-accessories/bag' => 'Camera bags protect gear on the move. Check the size, the padding and that your camera and lenses fit.',
        'electronics/camera-accessories/battery' => 'Camera batteries power the camera. Check that it fits your model and the capacity, and prefer original batteries.',
        'electronics/camera-accessories/charger' => 'Camera chargers recharge the battery. Check that it matches your battery and the voltage.',
        'electronics/camera-accessories/flash' => 'Camera flashes add light. Check the compatibility, the power and the hot-shoe type.',
        'electronics/camera-accessories/lens' => 'Camera lenses change how a camera sees. Check the mount, the focal length, the aperture and the condition of the glass.',
        'electronics/camera-accessories/lens-cleaning-kit' => 'Lens cleaning kits remove dust and marks. Check that it includes a blower, a brush and a safe cleaning cloth.',
        'electronics/camera-accessories/lens-hood' => 'Lens hoods reduce glare. Check that it fits your lens thread or mount.',
        'electronics/camera-accessories/memory-card' => 'Memory cards store photos and video. Check the capacity, the speed class and that the card is genuine.',
        'electronics/camera-accessories/studio-light' => 'Studio lights light a subject. Check the power, the colour temperature, the stand and the mount.',
        'electronics/camera-accessories/tripod' => 'Tripods hold a camera steady. Check the height, the weight it can carry and the head type.',
        'electronics/camera-photo/action-camera' => 'Action cameras are small, rugged cameras. Check the video resolution, the stabilisation, the water resistance and the battery.',
        'electronics/camera-photo/binocular' => 'Binoculars magnify distant sights. Check the magnification, the lens size, the weight and the focus.',
        'electronics/camera-photo/digital-camera' => 'Digital cameras suit everyday photos. Check the sensor, the zoom, the video and the battery.',
        'electronics/camera-photo/digital-photo-frame' => 'Digital photo frames display photos. Check the screen size, the resolution and how photos are loaded.',
        'electronics/camera-photo/drone' => 'Drones take aerial photos and video. Check the flight time, the range, the camera and the local rules for flying.',
        'electronics/camera-photo/dslr' => 'DSLRs are interchangeable-lens cameras with a mirror. Check the shutter count, the lens mount and the sensor.',
        'electronics/camera-photo/instant-camera' => 'Instant cameras print photos on the spot. Check the film type, its cost and its availability.',
        'electronics/camera-photo/mirrorless-camera' => 'Mirrorless cameras are interchangeable-lens cameras without a mirror. Check the lens mount, the sensor and the battery life.',
        'electronics/camera-photo/telescope' => 'Telescopes view the sky and distant objects. Check the aperture, the mount and the eyepieces included.',
        'electronics/camera-photo/video-camera' => 'Video cameras record footage. Check the resolution, the stabilisation, the audio inputs and the battery.',
        'electronics/cooling-heating/ac-accessories' => 'AC accessories include stands, covers and remotes. Check the fit for your unit and the material.',
        'electronics/cooling-heating/ac-bill-calculator' => 'This estimates the electricity cost of running an AC. Enter the power rating, the hours of use and your tariff for an estimate.',
        'electronics/cooling-heating/ac-ton-calculator' => 'This helps choose an AC capacity from the room size. Treat the result as a guide and confirm it with a technician.',
        'electronics/cooling-heating/air-conditioner' => 'Air conditioners cool rooms. Check the capacity, the energy rating, the type (split or window), the warranty and the installation.',
        'electronics/cooling-heating/air-cooler' => 'Air coolers cool with water evaporation. Check the tank size, the airflow and the room size it suits.',
        'electronics/cooling-heating/air-curtain' => 'Air curtains blow a sheet of air across a doorway. Check the width against your door and the airflow rating.',
        'electronics/cooling-heating/air-purifier' => 'Air purifiers clean indoor air. Check the room size rating, the filter type and the filter replacement cost.',
        'electronics/cooling-heating/dehumidifier' => 'Dehumidifiers remove moisture from the air. Check the daily capacity, the tank size and the room size.',
        'electronics/cooling-heating/fan' => 'Fans move air. Check the type (ceiling, stand, table), the speed, the noise and the power use.',
        'electronics/cooling-heating/humidifier' => 'Humidifiers add moisture to dry air. Check the tank size, the output and how easy it is to clean.',
        'electronics/cooling-heating/room-heater' => 'Room heaters warm a room in cold weather. Check the power rating, the safety cut-off and the room size.',
        'electronics/cooling-heating/water-heater-geyser' => 'Geysers heat water for bathrooms. Check the capacity, the power, the safety features and the installation.',
        'electronics/home-appliance/air-diffuser' => 'Air diffusers spread fragrance or oils. Check the tank size, the coverage and the safety shut-off.',
        'electronics/home-appliance/air-fryer' => 'Air fryers cook with hot air using little oil. Check the capacity, the power and the controls.',
        'electronics/home-appliance/barbeque-grill' => 'Barbeque grills cook over heat. Check the size, the fuel type and the build.',
        'electronics/home-appliance/bathroom-supplies' => 'Bathroom supplies cover fittings and helpers for a bathroom. Check the size, the material and the fixing.',
        'electronics/home-appliance/blender' => 'Blenders mix and puree food. Check the power, the jar size and the blade quality.',
        'electronics/home-appliance/coffee-machine' => 'Coffee machines brew coffee. Check the type, the capacity and how easy it is to clean.',
        'electronics/home-appliance/dishwasher' => 'Dishwashers wash dishes. Check the place settings, the water use and the space you have.',
        'electronics/home-appliance/dispenser' => 'Water dispensers give hot and cold water. Check the type, the capacity and the cooling system.',
        'electronics/home-appliance/electric-chula' => 'Electric chulas cook without gas. Check the power, the heating plate and the safety.',
        'electronics/home-appliance/electric-kettle' => 'Electric kettles boil water. Check the capacity, the power and the auto shut-off.',
        'electronics/home-appliance/filter-accessories' => 'Filter accessories include cartridges and parts. Check the model it fits and the replacement schedule.',
        'electronics/home-appliance/food-dehydrator' => 'Food dehydrators dry fruit, vegetables and more. Check the trays, the temperature range and the power.',
        'electronics/home-appliance/food-maker' => 'Food makers prepare items such as snacks or dough. Check the capacity, the power and the attachments.',
        'electronics/home-appliance/gas-stove' => 'Gas stoves cook with gas. Check the number of burners, the build and that the regulator suits your gas supply.',
        'electronics/home-appliance/iron' => 'Irons press clothes. Check the power, the soleplate and the steam function.',
        'electronics/home-appliance/kitchen-hood' => 'Kitchen hoods remove smoke and smell. Check the suction power, the width and the filter type.',
        'electronics/home-appliance/kitchen-storage' => 'Kitchen storage organises food and tools. Check the size, the material and whether it is airtight.',
        'electronics/home-appliance/microwave-oven' => 'Microwave ovens heat and cook food. Check the capacity, the power, the functions and the turntable.',
        'electronics/home-appliance/refrigerator' => 'Refrigerators keep food cold. Check the capacity, the type, the energy use and the compressor warranty.',
        'electronics/home-appliance/rice-cooker' => 'Rice cookers cook rice automatically. Check the capacity, the power and the inner pot coating.',
        'electronics/home-appliance/roti-maker' => 'Roti makers prepare flatbreads. Check the size, the power and the non-stick plate.',
        'electronics/home-appliance/sewing-machine' => 'Sewing machines stitch fabric. Check the type, the stitches available and the build.',
        'electronics/home-appliance/thermos-container' => 'Thermos containers keep food and drink hot or cold. Check the capacity, the insulation and the seal.',
        'electronics/home-appliance/toaster' => 'Toasters brown bread. Check the slots, the power and the browning control.',
        'electronics/home-appliance/vacuum-cleaner' => 'Vacuum cleaners clean floors. Check the suction power, the filter, the cord or battery and the noise.',
        'electronics/home-appliance/washing-machine' => 'Washing machines wash clothes. Check the capacity, the type (top or front load, semi or fully automatic), the water use and the warranty.',
        'electronics/home-appliance/water-filter' => 'Water filters purify drinking water. Check the filter stages, the capacity and the cost and timing of replacing cartridges.',
        'electronics/mobile-accessories/battery' => 'Mobile batteries replace a worn phone battery. Check the model it fits, the capacity and that it is original.',
        'electronics/mobile-accessories/car-charger' => 'Car chargers charge a phone from the car. Check the output, the ports and the build.',
        'electronics/mobile-accessories/data-cable' => 'Data cables charge and transfer data. Check the connector type, the length and the build quality.',
        'electronics/mobile-accessories/holder' => 'Mobile holders hold a phone in a car or on a desk. Check the grip, the mount and the phone sizes supported.',
        'electronics/mobile-accessories/other-accessories' => 'This covers other phone accessories. Check the compatibility with your phone model before you buy.',
        'electronics/mobile-accessories/phone-camera-lens' => 'Phone camera lenses add wide or macro views. Check the clip or mount and the glass quality.',
        'electronics/mobile-accessories/phone-charger' => 'Phone chargers power a phone. Check the output, the connector and that the product is original.',
        'electronics/mobile-accessories/phone-cover' => 'Phone covers protect a phone. Check the exact model, the material and the cut-outs for buttons and cameras.',
        'electronics/mobile-accessories/power-bank' => 'Power banks charge a phone on the go. Check the capacity, the output and the safety, and buy a recognised brand.',
        'electronics/mobile-accessories/screen-protector' => 'Screen protectors guard a phone screen. Check the exact model, the glass type and whether fitting help is included.',
        'electronics/mobile-accessories/selfie-stick' => 'Selfie sticks extend your reach for photos. Check the length, the grip and whether it has a remote.',
        'electronics/mobile-accessories/signal-booster' => 'Signal boosters improve weak phone reception. Check the network bands it supports and the coverage.',
        'electronics/mobile-accessories/vr-box' => 'VR boxes let a phone show virtual reality. Check the phone sizes it fits and the lens comfort.',
        'electronics/mobile-accessories/wireless-charger' => 'Wireless chargers charge a phone without a cable. Check that your phone supports it and the power output.',
        'electronics/portable-media/calculator' => 'Calculators do arithmetic. Check the type (basic or scientific), the display and the power source.',
        'electronics/portable-media/digital-dictionary' => 'Digital dictionaries look up words. Check the languages, the vocabulary and the screen.',
        'electronics/portable-media/ebook-reader' => 'Ebook readers display books. Check the screen type, the storage, the battery and the formats supported.',
        'electronics/portable-media/hdmi-splitter' => 'HDMI splitters send one video signal to several screens. Check the number of ports and the resolution supported.',
        'electronics/portable-media/ipod-player' => 'iPod players play music. Check the storage, the battery and the condition if used.',
        'electronics/portable-media/mp3-player' => 'MP3 players play music files. Check the storage, the battery life and the formats supported.',
        'electronics/portable-media/voice-recorder' => 'Voice recorders capture audio. Check the recording quality, the storage and the battery.',
        'electronics/telephony/fax-machine' => 'Fax machines send documents over a phone line. Check the line type, the speed and the paper type.',
        'electronics/telephony/ip-phone' => 'IP phones make calls over the internet. Check the protocol, the lines supported and the power option.',
        'electronics/telephony/pabx-system' => 'PABX systems link office phone extensions. Check the number of lines and extensions and the features.',
        'electronics/telephony/telephone-accessories' => 'Telephone accessories include cords and parts. Check the connector and the compatibility.',
        'electronics/telephony/telephone-set' => 'Telephone sets are desk or cordless phones. Check the type, the features and the line it suits.',
        'electronics/telephony/walkie-talkie' => 'Walkie-talkies give short-range two-way radio. Check the range, the channels and the battery, and the rules for use.',
        'electronics/tv-video/3d-glass' => '3D glasses show 3D video on compatible screens. Check the type (active or passive) against your TV.',
        'electronics/tv-video/accessories' => 'TV accessories include cables and stands. Check the connector type and the compatibility.',
        'electronics/tv-video/air-mouse' => 'Air mice control a smart TV or box by motion. Check the compatibility and the range.',
        'electronics/tv-video/android-tv-box' => 'Android TV boxes make a TV smart. Check the memory, the storage, the ports and the supported video quality.',
        'electronics/tv-video/bracket' => 'TV brackets mount a TV on a wall. Check the size and weight it supports and the wall type.',
        'electronics/tv-video/game-accessories' => 'Game accessories extend a console. Check that they fit your console model.',
        'electronics/tv-video/game-console' => 'Game consoles play video games. Check the model, the storage, what is in the box and the warranty.',
        'electronics/tv-video/game-controller' => 'Game controllers play games. Check the console it fits, the battery and the build.',
        'electronics/tv-video/remote' => 'TV remotes control a TV. Check the exact TV model and whether it is a universal or an original remote.',
        'electronics/tv-video/repair-service' => 'TV repair services fix faults. Ask for the diagnosis cost, the warranty on the repair and the parts used.',
        'electronics/tv-video/satellite-dish' => 'Satellite dishes receive TV signals. Check the size, the receiver and the installation.',
        'electronics/tv-video/size-calculator' => 'This helps pick a TV size from the viewing distance. Use it as a guide with your room layout.',
        'electronics/tv-video/television' => 'Televisions show video. Check the size, the resolution, the smart features, the ports and the warranty.',
        'electronics/tv-video/wireless-display-adapter' => 'Wireless display adapters mirror a phone or computer on a TV. Check the standard it supports and the TV ports.',
    ];
}

/* ---------------------------------------------------------------------------------------------- */

function category_guide_words(string $html): int
{
    return str_word_count(strip_tags($html)) + preg_match_all('/[\x{0980}-\x{09FF}]+/u', strip_tags($html));
}

/**
 * The guide section for a category page: about, what to check, how buying works, questions, and where to go next.
 * $cityName is set on "category in city" pages.
 */
function category_guide_html(array $cat, array $children, array $trail, ?string $cityName = null): string
{
    $name   = (string) $cat['name_en'];
    $path   = category_index()[(int) $cat['id']]['path'] ?? '';
    $parts  = explode('/', $path);
    $top    = $parts[0] ?? '';
    $level  = (int) $cat['level'];
    $topOv  = category_topic_overviews();
    $packs  = category_packs();
    $leafN  = category_leaf_notes();
    $pack   = $packs[implode('/', array_slice($parts, 0, 2))] ?? null;
    $leaf   = $leafN[$path] ?? null;
    $nameLc = $name;
    $where  = $cityName ? " in $cityName" : '';

    $h = '<section class="category-guide">';

    /* ---- about ---- */
    $h .= '<h2>About ' . e($name) . e($where) . '</h2>';
    if ($level === 1) {
        $h .= '<p>' . e($topOv[$top] ?? ($name . ' brings together listings from sellers across Bangladesh.')) . '</p>';
        if ($children) {
            $h .= '<p>Inside ' . e($name) . ' you can browse ' . natural_list(array_map(function ($c) { return e($c['name_en']); }, array_slice($children, 0, 12))) . '. Each of these has its own page with listings and buying advice, so you can go straight to the type of product or service you need.</p>';
        }
    } elseif ($level === 2) {
        $h .= '<p>' . e($pack['a'] ?? ($name . ' listings from sellers across Bangladesh.')) . '</p>';
        if ($children) {
            $h .= '<p>This section is divided into ' . natural_list(array_map(function ($c) { return e($c['name_en']); }, $children)) . '. Pick the one that matches what you are looking for, or browse the latest listings above.</p>';
        } else {
            $h .= '<p>' . e($name) . ' is part of ' . e($trail[0]['name_en'] ?? '') . '. New listings appear here as sellers add them, and you can message a seller directly about any listing that interests you.</p>';
        }
    } else {
        $h .= '<p>' . e($leaf ?? ($name . ' listings from sellers across Bangladesh.')) . '</p>';
        if (!empty($pack['a'])) {
            $h .= '<p>' . e($name) . ' sits within ' . e($trail[1]['name_en'] ?? '') . '. ' . e($pack['a']) . '</p>';
        }
    }
    if ($cityName) {
        $h .= '<p>This page shows ' . e($name) . ' listings from sellers in ' . e($cityName) . '. Buying locally makes it easier to see the item or visit the seller, to agree delivery and to sort out any problem quickly. If you cannot find what you want in ' . e($cityName) . ', go back to the main ' . e($name) . ' page to see listings from all over Bangladesh.</p>';
    }

    /* ---- what to check ---- */
    $tips = $pack['t'] ?? [];
    $h .= '<h2>What to check before you buy ' . e($name) . '</h2><ul>';
    foreach ($tips as $t) {
        $h .= '<li>' . e($t) . '</li>';
    }
    if ($level === 3 && $leaf) {
        $h .= '<li>Specific to ' . e($name) . ': ' . e(lcfirst(preg_replace('/^.*?\.\s+/', '', $leaf, 1) ?: $leaf)) . '</li>';
    }
    $h .= '<li>Ask the seller for clear photos of the actual item, or a short video, and compare them with the listing.</li>';
    $h .= '<li>Compare the same specification across two or three sellers, and include delivery and any installation in the price you compare.</li>';
    $h .= '<li>Keep the chat messages, the invoice and any warranty card until you are satisfied with the purchase.</li>';
    $h .= '</ul>';

    /* ---- how buying works ---- */
    $h .= '<h2>How buying ' . e($name) . ' works on SaleBari</h2>';
    $h .= '<p>SaleBari is a marketplace where independent sellers list their products and services. Open a listing to see the photos, the description and the seller\'s details, then use the WhatsApp or Call button to talk to the seller directly. You agree the price, the payment method and the delivery or pick-up with the seller. SaleBari does not take payment for products on the site, so no money moves through us and the seller\'s own return, exchange and warranty terms apply.</p>';
    $h .= '<p>New seller accounts and listings are reviewed by the SaleBari team before they go live. If you see something that looks wrong, such as a price that seems too good to be true, wrong information or a suspected scam, use the "Report this ad" link on the listing and we will look into it. You can also save listings with the heart icon to compare them later.</p>';

    /* ---- questions ---- */
    $h .= '<h2>Questions about ' . e($name) . '</h2>';
    $qa = [
        ['How do I buy ' . $name . $where . ' on SaleBari?', 'Open a listing, read the details, and message or call the seller using the buttons on the page. Agree the price, the payment and the delivery with the seller, and inspect the item before you pay in full where you can.'],
        ['Are the prices on SaleBari final?', 'Prices are set by the sellers and can change, so confirm the price, the availability, the delivery cost and the warranty with the seller before you pay.'],
        ['How can I tell that a ' . $name . ' listing is genuine?', 'Ask for real photos or a video, check the seller\'s details, meet or inspect the item where possible, and avoid paying a large advance to someone you do not know. Use "Report this ad" if something looks wrong.'],
    ];
    if ($pack && !empty($pack['q'])) {
        $qa[] = [$pack['q'], $pack['r']];
    }
    foreach ($qa as [$q, $a]) {
        $h .= '<details><summary>' . e($q) . '</summary><p>' . e($a) . '</p></details>';
    }

    /* ---- sell here ---- */
    $h .= '<h2>Selling ' . e($name) . ' on SaleBari</h2>';
    $h .= '<p>If you sell ' . e($name) . ', you can open a stall on SaleBari and reach buyers across Bangladesh. Add clear photos, an honest description, the price and your contact details, and keep your listing up to date so buyers see what is really available. <a href="' . e(base_path()) . '/sell/">Open your stall</a> or read the <a href="' . e(base_path()) . '/help/">Help Center</a> to see how it works.</p>';

    return $h . '</section>';
}

/** Buying advice under a product, so a product with a short description still has a full page. */
function product_guide_html(array $p, ?array $category, ?array $stall, ?array $brand): string
{
    $title = (string) $p['title_en'];
    $path  = $category ? (category_index()[(int) $category['id']]['path'] ?? '') : '';
    $parts = explode('/', $path);
    $pack  = category_packs()[implode('/', array_slice($parts, 0, 2))] ?? null;
    $leaf  = category_leaf_notes()[$path] ?? null;
    $cname = $category ? (string) $category['name_en'] : 'this product';
    $seller = $stall ? (string) $stall['name'] : ($brand ? (string) $brand['name'] : 'a SaleBari seller');
    $city   = $stall && !empty($stall['city']) ? (string) $stall['city'] : '';

    $h  = '<section class="pp-section category-guide product-guide" id="pp-guide">';
    $h .= '<h2>Before you buy ' . e($title) . '</h2>';
    $h .= '<p>' . e($leaf ?? ($pack['a'] ?? ($cname . ' listings from sellers across Bangladesh.'))) . '</p>';
    $h .= '<ul>';
    foreach ($pack['t'] ?? [] as $t) {
        $h .= '<li>' . e($t) . '</li>';
    }
    $h .= '<li>Ask ' . e($seller) . ' for clear photos of the actual item, or a short video, and compare them with this listing.</li>';
    $h .= '<li>Confirm the price, whether it includes delivery or installation, and what warranty or return terms apply, before you pay.</li>';
    $h .= '<li>Compare the same specification from two or three sellers, including delivery, before you decide.</li>';
    $h .= '<li>Keep the chat messages, the invoice and any warranty card until you are satisfied.</li></ul>';
    $h .= '<h2>Buying ' . e($title) . ' on SaleBari</h2>';
    $h .= '<p>This listing is posted by ' . e($seller) . ($city !== '' ? ' in ' . e($city) : '') . '. Use the WhatsApp or Call button on this page to talk to the seller about the price, the availability and the delivery. You agree the price, the payment method and the delivery or pick-up with the seller. SaleBari does not take payment for products on the site, so the seller\'s own return, exchange and warranty terms apply.</p>';
    $h .= '<p>Listings and stalls are reviewed by the SaleBari team before they go live. If something about this listing looks wrong, such as a price that seems too good to be true, wrong information or a suspected scam, use the "Report this ad" link on this page and we will look into it. You can also save the listing with the Save button to compare it later.</p>';
    $h .= '<h2>Questions about ' . e($title) . '</h2>';
    $qa = [
        ['How do I buy ' . $title . '?', 'Use the WhatsApp or Call button on this page to contact the seller. Agree the price, the payment and the delivery with them, and inspect the item before you pay in full where you can.'],
        ['Is the price final?', 'The seller sets the price and it can change, so confirm the price, the availability, the delivery cost and the warranty before you pay.'],
        ['How can I be sure the listing is genuine?', 'Ask for real photos or a video, check the seller\'s details, meet or inspect the item where possible, and avoid paying a large advance to someone you do not know.'],
    ];
    if ($pack && !empty($pack['q'])) {
        $qa[] = [$pack['q'], $pack['r']];
    }
    foreach ($qa as [$q, $a]) {
        $h .= '<details><summary>' . e($q) . '</summary><p>' . e($a) . '</p></details>';
    }
    if ($category) {
        $h .= '<p>See more in <a href="' . e(category_url($category)) . '">' . e($cname) . '</a> or <a href="' . e(base_path()) . '/help/">read the Help Center</a> for answers about buying on SaleBari.</p>';
    }
    return $h . '</section>';
}
