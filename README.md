# Khaos Control Courier Services

Welcome to the **beta version** of the Khaos Control Courier Services.

<!-- MarkdownTOC -->

- [Getting Started](#getting-started)
- [Types &amp; Objects](#types--objects)
   - [Types](#types)
      - [AddressType](#addresstype)
      - [DateTime](#datetime)
   - [Objects](#objects)
      - [CourierExportDataItem](#courierexportdataitem)
      - [Item](#item)
      - [Box](#box)
      - [BoxItem](#boxitem)
      - [CourierAddress](#courieraddress)
      - [CourierImportDataItem](#courierimportdataitem)
   - [Receiving & Responding to server calls](#receiving--responding-to-server-calls)
      - [CourierExportData](#courierexportdata)
         - [Properties](#properties)
         - [XML Response](#xml-response)
         - [JSON Response](#json-response)
      - [CourierImportData](#courierimportdata)
         - [Properties](#properties-1)
         - [XML Response](#xml-response-1)

<!-- /MarkdownTOC -->

# Getting Started

The API is very simple and uses a Push/Pull method. Data we export to you will be ``POST``ed to your defined endpoint and the data we import from you will be read from a URL you specify. Both of these requests will either be in ``JSON`` or ``XML`` and are defined in your configuration file

When we push data to you, you must ensure that you give a valid response code in the header, these can either be:

+ 200 (OK)
+ 400 (Bad request or bad data sent)
+ 500 (Error)

Error codes will make the API try again, therefore if you do not respond with a 200(OK) you experience duplicate data.

# Types &amp; Objects

## Types

### AddressType

The ``AddressType`` type is represented as an ``integer`` and will be one of the following:

+ 1 (Invoice)
+ 2 (Delivery)

### DateTime

The ``DateTime`` type is by represented as a ``string`` using the RFC 3339 format without the timezone offset.

``2018-01-18T12:20:48``

## Objects

### CourierExportDataItem

The ``CourierExportDataItem`` object is made up of the following properties:

Name | Type | Required | Description
--- | --- | --- | ---
**Items** | [Item](#item) | Yes | The items of the order
**Boxes** | [Box](#box) | Yes | The information of the parcels/boxes the item have been put into
**InvoiceAddress** | [CourierAddress](#courieraddress) | Yes | The invoice/billing address of the order
**DeliveryAddress** | [CourierAddress](#courieraddress) | Yes | The delivery address of the order
**InvoiceID** | String | Yes | This is the Invoice ID which uniquely identifies the invoice within Khaos Control
**CompanyCode** | String | | The company code within Khaos Control that is associated to the customer
**TaxRef** | String | | The tax reference of the customer
**ECCompany** | Boolean | | This specifies if the company is a European Commission company
**InvoiceCode** | String | Yes | The Invoice Code which is associated to this order
**InvoiceDate** | [DateTime](#datetime) | Yes | The date the invoice was created
**OrderDate** | [DataTime](#datetime) | | The date the order was created
**SOrderCode** | String | | The sales order code that the invoice is associated to
**SOrderID** | String | The unique ID of the Sales Order that the invoice is associated to
**AssociatedRef** | String | | This is the Associated Ref that represent a web order number / external system order number
**DeliveryDate** | [DateTime](#datetime) | | The date which has been specified for delivery within Khaos Control
**RequiredDate** | [DateTime](#datetime) | | The required by date specified within Khaos Control
**ItemTotal** | Double | Yes | The total amount of the invoice in the order's currency
**ItemTaxTotal** | Double | Yes | This is the total tax of the invoice, in the order's currency
**DeliveryTotal** | Double | Yes | This is the total delivery cost chartged on the invoice, in the order's currency
**DeliveryTaxTotal** | Double | Yes | This is the delivery tax total of the invoice, in the order's currency
**Weight** | Double | Yes | The calculated weight
**CurrencyCode** | String | Yes | This is the code of the order's currency
**CurrencyName** | String | | This is the name of the order's currency
**CurrencyID** | String  | Yes | This is the ID of the order's currency
**InvoiceNote** | String | | The note associated to the invoice
**PickingListNote** | String | | The poicking note associated to the invoice
**ChannelID** | String | | The is the ID of the channel from where the invoice has been generated

### Item

The ``Item`` object is made up of the following properties:

Name | Type | Required | Description
--- | --- | --- | ---
**ItemID** | String | Yes | This is the unique ID of the item
**QtyUser** | Double | Yes | This is the quantity of the item
**StockID** | String | Yes | This is the unique stock ID of the item
**StockDesc** | String | Yes | This is the description of the item
**UnitNet** | Double | Yes | This is the Net Unit amount per item, within the order's currency
**UnitTax** | Double | Yes | This is the Unit Tax amount per item, within the order's currency
**NetTotal** | Double | Yes | This is the net total of the item line, taking *QtyUser* into account
**StockCode** | String | | This is the code identifier that is associated to the item
**StockType** | String | | This is the category/type of the item
**ManufCounry** | String | | This is the manufacturer's country name
**ManufCountryCode2** | String | | This is the country code for the manufacturer in ISO 3116-2 format
**ManufCountryCode3** | String | | This is the country code for the manufacturer in ISO 3116-3 format
**IntrastatCode** | String | | This is the Invoice ID associated to the item
**HermonisationCode** | String | | This is the Hermonisation Code defined within Khaos Control
**HermonisationDesc** | string | | This is the Hermonisation Description defined within Khaos Control
**ImportRef** | String | | This is a unique import reference generated within Khaos Control
**Weight** | Double | Yes | This is the calculated weight of the item within Khaos Control

### Box

The ``Box`` object is made up of the following properties:

Name | Type | Requried | Description
--- | --- | --- | ---
**BoxItem** | [BoxItem](#boxitem) | Yes | This is an aggregated type of ``BoxItem`` items
**ItemID** | String | | This is the unique identifier of the box
**BoxNote** | String | | This is the note that provides additional information for the box
**BoxNumber** | Integer | | This is the number that identifies the box when multiple boxes are part of the same invoice
**BoxWidth** | Double | | This is the width of the box
**BoxDepth** | Double | | This is the depth of the box
**BoxHeight** | Double | | This is the height of the box
**BoxPackagingWeight** | Double | | This is weight of the packaging of the box
**BoxWeightScaled** | Double | Yes | This is the weight of the box that has already scaled from within Khaos Control and it includes packaging

### BoxItem

The ``BoxItem`` object is made up of the following properties:

Name | Type | Required | Description
--- | --- | --- | ---
**ItemID** | String | Yes | This is an ItemID that identifies uniquely an item inside a box
**QtyUser** | Double | Yes | The is the quantity of the item
**StockID** | String | Yes | This is the stock ID associated to the item
**StockDesc** | String | Yes | This is the description of the item
**UnitNet** | Double | Yes | This is the individual unit net amount of the item
**UnitTax** | Double | Yes | This is the individual unit tax amount of the item
**NetTotal** | Double | Yes | This is the net total amount of the item, multipled by the *QtyUser*
**StockCode** | String | | This is the stock code of the item
**StockType** | String | | This is the category/type of the item
**ManufCountryCode2** | String | | This is the country code of the manufacturer in an ISO 3166-2 format
**ManufCountryCode3** | String | | This is the country code of the manufacturer in an ISO 3166-3 format
**IntrastatCode** | String | | This is the invoice ID associated to the item
**HermonisationCode** | String | | This is the Hermonisation code that identifies uniquely a box item
**HermonisationDescription** | String | | This is the Hermonisation description that uniquely identifies a box item
**Weight** | Double | | This is the calculated weight of the item

### CourierAddress

The ``CourierAddress`` object is made up of the following properties:

Name | Type | Required | Description
--- | --- | --- | ---
**CourierNote** | String | | The note to the courier
**CompanyName** | String | Yes | The name of the company/building
**Address1** | String | Yes | The first line of the address
**Address2** | String | Yes | The second line of the address
**Locality** | String | | The locality of the address
**Town** | String | Yes | The town associated to the address
**County** | String | | The county associated to the address
**Postcode** | String | Yes | The postcode associated to the address
**AddrTel** | String | | The telephone number associated to the address
**AddrEmail** | String | | The email address associated to the address
**AddrType** | [AddressType](#addresstype) | | This is the address type from within Khaos Control.
**CountryID** | Integer | Yes | The ID of the country associated to the address
**CountryName** | String | Yes | The country associated to the address in a named format
**CountryCode2** | String | | The code of the country associated to the address in an ISO 3166-2 format
**CountryCode3** | String | | The code of the country associated to the address in an ISO 3166-3 format
**EUNumber** | Boolean | |
**Title** | String | | The title of the recipient associated to the address
**Forename** | String | Yes | The forename/first name of the recipient associated to the address
**Surname** | String | Yes | The surname/last name of the recipient associated to the address
**CtTel** | String | | The contact telephone number associated to the recipient
**CtTel2** | String | | An alternative telephone number associated to the recipient
**CtEmail** | String | | The email address associated to the recipient

### CourierImportDataItem

The ``CourierImportDataItem`` object is made up of the following properties:

Name | Type | Required | Description
--- | --- | --- | ---
**InvoiceID** | String | Yes | The unique invoice ID associated to the imported ``CourierExportDataItem``
**ItemID** | String | | 
**IsSuccess** | Boolean | Yes | The status of whether the import was successful or not, in a boolean value
**ConsignmentRef** | String | | The consignment reference generated from the import
**TrackingNo** | String | | The tracking number generated for the imported item
**Errors** | String | Yes | This is an aggregate type of error messages in case the shipment failed
**LabelURL** | String | | The URL associated to the import, showing the label generated
**RawLabelData** | BytesArray | | The image or PDF associated to the import representing the label

## Receiving & Responding to server calls

### CourierExportData

This is the data received when a Khaos Control user assigns a package to a courier via the Sales Invoice Manager. The end point URL is setup within the Khaos Control instance.

#### Properties

Name | Type | Required | Description
--- | --- | --- | ---
**ServiceCode** | String | Yes | 
**Items** | Array[[CourierExportDataItem](#courierexportdataitem)] | Yes | The items exported
**IncludePackaging** | Boolean | Yes | Whether the items include packaging or not
**AverageWeight** | Double | Yes | The average weight of each item
**WeightScale** | Double | | The unit used to convert the dimensions of the item, e.g. dividing by 1 will convert the standard cm unit into metres
**DimensionScale** | Double | | The unit used to convert the weight of the item, e.g. diving by 1 will convert the standard grams unit into kilograms

#### XML Response

```xml
<CourierExportData>
    <ServiceCode>1</ServiceCode>
    <Items>
        <CourierExportDataItem>
            <Items>
                <Item>
                    <ItemID>BHXAV402G00M3EM</ItemID>
                    <QtyUser>20</QtyUser>
                    <StockID>7108</StockID>
                    <StockDesc>Tester</StockDesc>
                    <UnitNet>16.67</UnitNet>
                    <UnitTax>3.334</UnitTax>
                    <NetTotal>333.4</NetTotal>
                    <StockCode>7108</StockCode>
                    <StockType>System &amp; Miscellaneous</StockType>
                    <ManufCountry>Canada</ManufCountry>
                    <ManufCountryCode3>CAN</ManufCountryCode3>
                    <ManufCountryCode2>CA</ManufCountryCode2>
                    <IntrastatCode>52093900</IntrastatCode>
                    <HarmonisationCode>0000000001</HarmonisationCode>
                    <HarmonisationDesc>1</HarmonisationDesc>
                    <ImportRef></ImportRef>
                    <Weight>120</Weight>
                </Item>
                <Item>
                    <ItemID>BHXAV403000M3EM</ItemID>
                    <QtyUser>20</QtyUser>
                    <StockID>7624</StockID>
                    <StockDesc>Deans Test</StockDesc>
                    <UnitNet>1.67</UnitNet>
                    <UnitTax>0.334</UnitTax>
                    <NetTotal>33.4</NetTotal>
                    <StockCode>TEST12</StockCode>
                    <StockType>Testing</StockType>
                    <ManufCountry>France</ManufCountry>
                    <ManufCountryCode3>FRA</ManufCountryCode3>
                    <ManufCountryCode2>FR</ManufCountryCode2>
                    <IntrastatCode></IntrastatCode>
                    <HarmonisationCode></HarmonisationCode>
                    <HarmonisationDesc></HarmonisationDesc>
                    <ImportRef></ImportRef>
                    <Weight>50</Weight>
                </Item>
            </Items>
            <Boxes>
                <Box>
                    <items>
                        <BoxItem>
                            <ItemID>2373</ItemID>
                            <QtyUser>18</QtyUser>
                            <StockID>7108</StockID>
                            <StockDesc>Tester</StockDesc>
                            <UnitNet>16.67</UnitNet>
                            <UnitTax>3.334</UnitTax>
                            <NetTotal>333.4</NetTotal>
                            <StockCode>7108</StockCode>
                            <StockType>System &amp; Miscellaneous</StockType>
                            <ManufCountry>Canada</ManufCountry>
                            <ManufCountryCode3>CAN</ManufCountryCode3>
                            <ManufCountryCode2>CA</ManufCountryCode2>
                            <IntrastatCode>52093900</IntrastatCode>
                            <HarmonisationCode>0000000001</HarmonisationCode>
                            <HarmonisationDesc>1</HarmonisationDesc>
                            <Weight>120</Weight>
                        </BoxItem>
                        <BoxItem>
                            <ItemID>2374</ItemID>
                            <QtyUser>18</QtyUser>
                            <StockID>7624</StockID>
                            <StockDesc>Deans Test</StockDesc>
                            <UnitNet>1.67</UnitNet>
                            <UnitTax>0.334</UnitTax>
                            <NetTotal>33.4</NetTotal>
                            <StockCode>TEST12</StockCode>
                            <StockType>Testing</StockType>
                            <ManufCountry>France</ManufCountry>
                            <ManufCountryCode3>FRA</ManufCountryCode3>
                            <ManufCountryCode2>FR</ManufCountryCode2>
                            <IntrastatCode></IntrastatCode>
                            <HarmonisationCode></HarmonisationCode>
                            <HarmonisationDesc></HarmonisationDesc>
                            <Weight>50</Weight>
                        </BoxItem>
                    </items>
                    <ItemID>1447</ItemID>
                    <BoxNote></BoxNote>
                    <BoxNumber>0</BoxNumber>
                    <BoxWidth>30</BoxWidth>
                    <BoxDepth>30</BoxDepth>
                    <BoxHeight>30</BoxHeight>
                    <BoxPackagingWeight>0</BoxPackagingWeight>
                    <BoxWeightScaled>3060</BoxWeightScaled>
                    <BoxWeightCalculated>3060</BoxWeightCalculated>
                </Box>
                <Box>
                    <items>
                        <BoxItem>
                            <ItemID>2375</ItemID>
                            <QtyUser>2</QtyUser>
                            <StockID>7624</StockID>
                            <StockDesc>Deans Test</StockDesc>
                            <UnitNet>1.67</UnitNet>
                            <UnitTax>0.334</UnitTax>
                            <NetTotal>33.4</NetTotal>
                            <StockCode>TEST12</StockCode>
                            <StockType>Testing</StockType>
                            <ManufCountry>France</ManufCountry>
                            <ManufCountryCode3>FRA</ManufCountryCode3>
                            <ManufCountryCode2>FR</ManufCountryCode2>
                            <IntrastatCode></IntrastatCode>
                            <HarmonisationCode></HarmonisationCode>
                            <HarmonisationDesc></HarmonisationDesc>
                            <Weight>50</Weight>
                        </BoxItem>
                        <BoxItem>
                            <ItemID>2376</ItemID>
                            <QtyUser>2</QtyUser>
                            <StockID>7108</StockID>
                            <StockDesc>Tester</StockDesc>
                            <UnitNet>16.67</UnitNet>
                            <UnitTax>3.334</UnitTax>
                            <NetTotal>333.4</NetTotal>
                            <StockCode>7108</StockCode>
                            <StockType>System &amp; Miscellaneous</StockType>
                            <ManufCountry>Canada</ManufCountry>
                            <ManufCountryCode3>CAN</ManufCountryCode3>
                            <ManufCountryCode2>CA</ManufCountryCode2>
                            <IntrastatCode>52093900</IntrastatCode>
                            <HarmonisationCode>0000000001</HarmonisationCode>
                            <HarmonisationDesc>1</HarmonisationDesc>
                            <Weight>120</Weight>
                        </BoxItem>
                    </items>
                    <ItemID>1448</ItemID>
                    <BoxNote></BoxNote>
                    <BoxNumber>0</BoxNumber>
                    <BoxWidth>30</BoxWidth>
                    <BoxDepth>30</BoxDepth>
                    <BoxHeight>30</BoxHeight>
                    <BoxPackagingWeight>0</BoxPackagingWeight>
                    <BoxWeightScaled>340</BoxWeightScaled>
                    <BoxWeightCalculated>340</BoxWeightCalculated>
                </Box>
            </Boxes>
            <InvoiceAddress>
                <CourierNote></CourierNote>
                <CompanyName></CompanyName>
                <Address1>Test Order</Address1>
                <Address2>18</Address2>
                <Locality></Locality>
                <Town>Wigan</Town>
                <County>Lancashire</County>
                <PostCode>WN3 5QJ</PostCode>
                <AddrTel></AddrTel>
                <AddrFax></AddrFax>
                <AddrEmail>psilman@keystonesoftware.co.uk</AddrEmail>
                <AddrType>0</AddrType>
                <CountryID>826</CountryID>
                <CountryName>United Kingdom</CountryName>
                <CountryCode2>GB</CountryCode2>
                <CountryCode3>GBR</CountryCode3>
                <EUMember>False</EUMember>
                <Title></Title>
                <Forename>Test</Forename>
                <Surname>Test</Surname>
                <FullName>Test Test</FullName>
                <CtTel></CtTel>
                <CtTel2></CtTel2>
                <CtEmail>psilman@keystonesoftware.co.uk</CtEmail>
            </InvoiceAddress>
            <DeliveryAddress>
                <CourierNote></CourierNote>
                <CompanyName></CompanyName>
                <Address1>Test Order</Address1>
                <Address2>18</Address2>
                <Locality></Locality>
                <Town>Wigan</Town>
                <County>Lancashire</County>
                <PostCode>WN3 5QJ</PostCode>
                <AddrTel></AddrTel>
                <AddrFax></AddrFax>
                <AddrEmail>psilman@keystonesoftware.co.uk</AddrEmail>
                <AddrType>0</AddrType>
                <CountryID>826</CountryID>
                <CountryName>United Kingdom</CountryName>
                <CountryCode2>GB</CountryCode2>
                <CountryCode3>GBR</CountryCode3>
                <EUMember>False</EUMember>
                <Title></Title>
                <Forename>Test</Forename>
                <Surname>Test</Surname>
                <FullName>Test Test</FullName>
                <CtTel></CtTel>
                <CtTel2></CtTel2>
                <CtEmail>psilman@keystonesoftware.co.uk</CtEmail>
            </DeliveryAddress>
            <InvoiceID>BHXAV402000M3EM</InvoiceID>
            <CompanyCode>168202</CompanyCode>
            <TaxRef>none</TaxRef>
            <ECCompany>False</ECCompany>
            <InvoiceCode>INV105853</InvoiceCode>
            <InvoiceDate>1899-12-30T00:00:00</InvoiceDate>
            <OrderDate>1899-12-30T00:00:00</OrderDate>
            <SOrderCode>S111832</SOrderCode>
            <SOrderID>111832</SOrderID>
            <AssociatedRef>N/A</AssociatedRef>
            <DeliveryDate>1899-12-30T00:00:00</DeliveryDate>
            <RequiredDate>1899-12-30T00:00:00</RequiredDate>
            <ItemTotal>366.8</ItemTotal>
            <ItemTaxTotal>73.36</ItemTaxTotal>
            <DeliveryTotal>0</DeliveryTotal>
            <DeliveryTaxTotal>0</DeliveryTaxTotal>
            <Weight>0</Weight>
            <CurrencyCode>GBP</CurrencyCode>
            <CurrencyName>Pound Sterling</CurrencyName>
            <CurrencyID>1</CurrencyID>
            <InvoiceNote>All our invoices are subject to the Late Payments of Commercial Debts Act 1998 and late Payment of Commercial Debts Regulations 2002.</InvoiceNote>
            <PickingListNote>Thank you for your valued custom</PickingListNote>
            <ChannelID>0</ChannelID>
        </CourierExportDataItem>
    </Items>
    <IncludePackaging>False</IncludePackaging>
    <AverageWeight>0</AverageWeight>
    <WeightScale>0</WeightScale>
    <DimensionScale>0</DimensionScale>
</CourierExportData>
```

#### JSON Response

```json
{
   "ServiceCode": "2",
   "Items": [{
      "Items": [{
            "ItemID": "BHXAV402G00M3EM",
            "QtyUser": 20.0,
            "StockID": "7108",
            "StockDesc": "Tester",
            "UnitNet": 16.67,
            "UnitTax": 3.334,
            "NetTotal": 333.4,
            "StockCode": "7108",
            "StockType": "System & Miscellaneous",
            "ManufCountry": "Canada",
            "ManufCountryCode3": "CAN",
            "ManufCountryCode2": "CA",
            "IntrastatCode": "52093900",
            "HarmonisationCode": "0000000001",
            "HarmonisationDesc": "1",
            "ImportRef": "",
            "Weight": 120.0
         },
         {
            "ItemID": "BHXAV403000M3EM",
            "QtyUser": 20.0,
            "StockID": "7624",
            "StockDesc": "Deans Test",
            "UnitNet": 1.67,
            "UnitTax": 0.334,
            "NetTotal": 33.4,
            "StockCode": "TEST12",
            "StockType": "Testing",
            "ManufCountry": "France",
            "ManufCountryCode3": "FRA",
            "ManufCountryCode2": "FR",
            "IntrastatCode": "",
            "HarmonisationCode": "",
            "HarmonisationDesc": "",
            "ImportRef": "",
            "Weight": 50.0
         }
      ],
      "Boxes": [{
            "items": [{
                  "ItemID": "2373",
                  "QtyUser": 18.0,
                  "StockID": "7108",
                  "StockDesc": "Tester",
                  "UnitNet": 16.67,
                  "UnitTax": 3.334,
                  "NetTotal": 333.4,
                  "StockCode": "7108",
                  "StockType": "System & Miscellaneous",
                  "ManufCountry": "Canada",
                  "ManufCountryCode3": "CAN",
                  "ManufCountryCode2": "CA",
                  "IntrastatCode": "52093900",
                  "HarmonisationCode": "0000000001",
                  "HarmonisationDesc": "1",
                  "Weight": 120.0
               },
               {
                  "ItemID": "2374",
                  "QtyUser": 18.0,
                  "StockID": "7624",
                  "StockDesc": "Deans Test",
                  "UnitNet": 1.67,
                  "UnitTax": 0.334,
                  "NetTotal": 33.4,
                  "StockCode": "TEST12",
                  "StockType": "Testing",
                  "ManufCountry": "France",
                  "ManufCountryCode3": "FRA",
                  "ManufCountryCode2": "FR",
                  "IntrastatCode": "",
                  "HarmonisationCode": "",
                  "HarmonisationDesc": "",
                  "Weight": 50.0
               }
            ],
            "ItemID": "1447",
            "BoxNote": "",
            "BoxNumber": 0,
            "BoxWidth": 30.0,
            "BoxDepth": 30.0,
            "BoxHeight": 30.0,
            "BoxPackagingWeight": 0.0,
            "BoxWeightScaled": 3060.0,
            "BoxWeightCalculated": 3060.0
         },
         {
            "items": [{
                  "ItemID": "2375",
                  "QtyUser": 2.0,
                  "StockID": "7624",
                  "StockDesc": "Deans Test",
                  "UnitNet": 1.67,
                  "UnitTax": 0.334,
                  "NetTotal": 33.4,
                  "StockCode": "TEST12",
                  "StockType": "Testing",
                  "ManufCountry": "France",
                  "ManufCountryCode3": "FRA",
                  "ManufCountryCode2": "FR",
                  "IntrastatCode": "",
                  "HarmonisationCode": "",
                  "HarmonisationDesc": "",
                  "Weight": 50.0
               },
               {
                  "ItemID": "2376",
                  "QtyUser": 2.0,
                  "StockID": "7108",
                  "StockDesc": "Tester",
                  "UnitNet": 16.67,
                  "UnitTax": 3.334,
                  "NetTotal": 333.4,
                  "StockCode": "7108",
                  "StockType": "System & Miscellaneous",
                  "ManufCountry": "Canada",
                  "ManufCountryCode3": "CAN",
                  "ManufCountryCode2": "CA",
                  "IntrastatCode": "52093900",
                  "HarmonisationCode": "0000000001",
                  "HarmonisationDesc": "1",
                  "Weight": 120.0
               }
            ],
            "ItemID": "1448",
            "BoxNote": "",
            "BoxNumber": 0,
            "BoxWidth": 30.0,
            "BoxDepth": 30.0,
            "BoxHeight": 30.0,
            "BoxPackagingWeight": 0.0,
            "BoxWeightScaled": 340.0,
            "BoxWeightCalculated": 340.0
         }
      ],
      "InvoiceAddress": {
         "CourierNote": "",
         "CompanyName": "",
         "Address1": "Test Order",
         "Address2": "18",
         "Locality": "",
         "Town": "Wigan",
         "County": "Lancashire",
         "PostCode": "WN3 5QJ",
         "AddrTel": "",
         "AddrFax": "",
         "AddrEmail": "psilman@keystonesoftware.co.uk",
         "AddrType": 0,
         "CountryID": 826,
         "CountryName": "United Kingdom",
         "CountryCode2": "GB",
         "CountryCode3": "GBR",
         "EUMember": false,
         "Title": "",
         "Forename": "Test",
         "Surname": "Test",
         "FullName": "Test Test",
         "CtTel": "",
         "CtTel2": "",
         "CtEmail": "psilman@keystonesoftware.co.uk"
      },
      "DeliveryAddress": {
         "CourierNote": "",
         "CompanyName": "",
         "Address1": "Test Order",
         "Address2": "18",
         "Locality": "",
         "Town": "Wigan",
         "County": "Lancashire",
         "PostCode": "WN3 5QJ",
         "AddrTel": "",
         "AddrFax": "",
         "AddrEmail": "psilman@keystonesoftware.co.uk",
         "AddrType": 0,
         "CountryID": 826,
         "CountryName": "United Kingdom",
         "CountryCode2": "GB",
         "CountryCode3": "GBR",
         "EUMember": false,
         "Title": "",
         "Forename": "Test",
         "Surname": "Test",
         "FullName": "Test Test",
         "CtTel": "",
         "CtTel2": "",
         "CtEmail": "psilman@keystonesoftware.co.uk"
      },
      "InvoiceID": "BHXAV402000M3EM",
      "CompanyCode": "168202",
      "TaxRef": "none",
      "ECCompany": false,
      "InvoiceCode": "INV105853",
      "InvoiceDate": "1899-12-30T00:00:00",
      "OrderDate": "1899-12-30T00:00:00",
      "SOrderCode": "S111832",
      "SOrderID": "111832",
      "AssociatedRef": "N/A",
      "DeliveryDate": "1899-12-30T00:00:00",
      "RequiredDate": "1899-12-30T00:00:00",
      "ItemTotal": 366.8,
      "ItemTaxTotal": 73.36,
      "DeliveryTotal": 0.0,
      "DeliveryTaxTotal": 0.0,
      "Weight": 0.0,
      "CurrencyCode": "GBP",
      "CurrencyName": "Pound Sterling",
      "CurrencyID": 1,
      "InvoiceNote": "All our invoices are subject to the Late Payments of Commercial Debts Act 1998 and late Payment of Commercial Debts Regulations 2002.",
      "PickingListNote": "Thank you for your valued custom",
      "ChannelID": "0"
   }],
   "IncludePackaging": false,
   "AverageWeight": 0.0,
   "WeightScale": 0.0,
   "DimensionScale": 0.0
}
```

### CourierImportData

This is the object needed for importing responses from the Courier, the URL for importing is defined via the *Courier Settings* in Khaos Control

#### Properties

Name | Type | Required | Description
--- | --- | --- | ---
**Items** | Array[[CourierImportDataItem](#courierimportdataitem)] | Yes | The items to import

#### XML Response

```xml
<CourierImportData>
    <Items>
        <CourierImportDataItem>
            <InvoiceID>BHXAV402000M3EM</InvoiceID>
            <ItemID>1447</ItemID>
            <IsSuccess>True</IsSuccess>
            <ConsignmentRef>Some consignemnt - 0</ConsignmentRef>
            <RawLabelData>.....</RawLabelData>
        </CourierImportDataItem>
        <CourierImportDataItem>
            <InvoiceID>BHXAV402000M3EM</InvoiceID>
            <ItemID>1448</ItemID>
            <IsSuccess>True</IsSuccess>
            <ConsignmentRef>Some consignemnt - 1</ConsignmentRef>
            <RawLabelData>..</RawLabelData>
        </CourierImportDataItem>
    </Items>
</CourierImportData>
```

```json
{
  "Items": [
    {
      "InvoiceID": "BHXAV402000M3EM",
      "ItemID": "1447",
      "IsSuccess": true,
      "ConsignmentRef": "Some consignemnt - 0",
      "Errors": [],
      "LabelURL": "http://192.168.50.60:45455/api/values/2.pdf"
    },
    {
      "InvoiceID": "BHXAV402000M3EM",
      "ItemID": "1448",
      "IsSuccess": true,
      "ConsignmentRef": "Some consignemnt - 1",
      "Errors": [],
      "LabelURL": "http://192.168.50.60:45455/api/values/2.pdf"
    }
  ]
}

```
