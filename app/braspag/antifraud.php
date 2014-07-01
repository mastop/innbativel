<?php

class FraudAnalysis {
  public $request; // FraudAnalysisRequest
}

class AbstractRequest {
  public $RequestId; // guid
  public $AccessKey; // guid
}

class AbstractAntiFraudRequest extends AbstractRequest{
  public $AntiFraudSequenceType; // AntiFraudSequenceType
  public $AntiFraudRequest; // AntiFraudRequest
}

class FraudAnalysisRequest extends AbstractAntiFraudRequest{
  public $MerchantId; // guid
  public $DocumentData; // AntiFraudDocumentData
  public $AuthorizeTransactionRequest; // AuthorizeTransactionRequest
}

class AntiFraudSequenceType {
  const Undefined = 'Undefined';
  const AnalyseOnly = 'AnalyseOnly';
  const AnalyseAndAuthorizeOnSuccess = 'AnalyseAndAuthorizeOnSuccess';
  const AuthorizeAndAnalyseOnSuccess = 'AuthorizeAndAnalyseOnSuccess';
  const AuthorizeAndAnalyseAlways = 'AuthorizeAndAnalyseAlways';
}

class AntiFraudRequest {
  public $BankInfoData; // BankInfoData
  public $BillToData; // BillToData
  public $BusinessRulesScoreThreshold; // int
  public $CardData; // CardData
  public $Comments; // string
  public $DecisionManagerData; // DecisionManagerData
  public $FundTransferData; // FundTransferData
  public $InvoiceHeaderData; // InvoiceHeaderData
  public $ItemDataCollection; // ArrayOfItemData
  public $MerchantDefinedData; // MerchantDefinedData
  public $MerchantReferenceCode; // string
  public $PurchaseTotalsData; // PurchaseTotalsData
  public $ShipToData; // ShipToData
}

class BankInfoData {
  public $Address; // string
  public $Code; // string
  public $BranchCode; // string
  public $City; // string
  public $Country; // string
  public $Name; // string
  public $SwiftCode; // string
}

class BillToData {
  public $City; // string
  public $Country; // string
  public $CustomerId; // string
  public $DateOfBirth; // dateTime
  public $DomainName; // string
  public $Email; // string
  public $FirstName; // string
  public $HostName; // string
  public $HttpBrowserCookiesAccepted; // boolean
  public $HttpBrowserEmail; // string
  public $HttpBrowserType; // string
  public $IpAddress; // string
  public $IpNetworkAddress; // string
  public $LastName; // string
  public $PhoneNumber; // string
  public $PostalCode; // string
  public $State; // string
  public $Street1; // string
  public $Street2; // string
}

class CardData {
  public $AccountNumber; // string
  public $Bin; // string
  public $Card; // CardType
  public $ExpirationMonth; // string
  public $ExpirationYear; // string
}

class CardType {
  const Undefined = 'Undefined';
  const Visa = 'Visa';
  const Mastercard = 'Mastercard';
  const Eurocard = 'Eurocard';
  const AmericanExpress = 'AmericanExpress';
  const Discover = 'Discover';
  const DinersClub = 'DinersClub';
  const CarteBlanche = 'CarteBlanche';
  const JBC = 'JBC';
  const EnRoute = 'EnRoute';
  const JAL = 'JAL';
  const MaestroUkDomestic = 'MaestroUkDomestic';
  const Delta = 'Delta';
  const VisaElectron = 'VisaElectron';
  const Dankort = 'Dankort';
  const Laser = 'Laser';
  const CarteBleue = 'CarteBleue';
  const CartaSi = 'CartaSi';
  const EncondedAccountNumber = 'EncondedAccountNumber';
  const Uatp = 'Uatp';
  const MaestroInternational = 'MaestroInternational';
  const GeMoneyUkCard = 'GeMoneyUkCard';
  const Style = 'Style';
  const Elo = 'Elo';
}

class DecisionManagerData {
  public $TravelData; // TravelData
}

class TravelData {
  public $CompleteRoute; // string
  public $DepartureDateTime; // dateTime
  public $JourneyType; // string
  public $TravelLegDataCollection; // ArrayOfTravelLegData
}

class TravelLegData {
  public $Origin; // string
  public $Destination; // string
}

class FundTransferData {
  public $AccountName; // string
  public $AccountNumber; // string
  public $BankCheckDigit; // string
  public $Iban; // string
}

class InvoiceHeaderData {
  public $IsGift; // boolean
  public $MerchantDescriptor; // string
  public $ReturnsAccepted; // boolean
  public $Tender; // TenderType
}

class TenderType {
  const Undefined = 'Undefined';
  const Consumer = 'Consumer';
  const Corporate = 'Corporate';
  const Debit = 'Debit';
  const Cod = 'Cod';
  const Check = 'Check';
  const P2P = 'P2P';
  const Private1 = 'Private1';
  const Other = 'Other';
}

class ItemData {
  public $GiftCategory; // GiftCategoryType
  public $HostHedge; // HostHedgeType
  public $NonSensicalHedge; // NonSensicalHedgeType
  public $ObscenitiesHedge; // ObscenitiesHedgeType
  public $PassengerData; // PassengerData
  public $PhoneHedge; // PhoneHedgeType
  public $ProductData; // ProductData
  public $TimeHedge; // TimeHedgeType
  public $VelocityHedge; // VelocityHedgeType
}

class GiftCategoryType {
  const Undefined = 'Undefined';
  const Yes = 'Yes';
  const No = 'No';
  const Off = 'Off';
}

class HostHedgeType {
  const Undefined = 'Undefined';
  const Low = 'Low';
  const Normal = 'Normal';
  const High = 'High';
  const Off = 'Off';
}

class NonSensicalHedgeType {
  const Undefined = 'Undefined';
  const Low = 'Low';
  const Normal = 'Normal';
  const High = 'High';
  const Off = 'Off';
}

class ObscenitiesHedgeType {
  const Undefined = 'Undefined';
  const Low = 'Low';
  const Normal = 'Normal';
  const High = 'High';
  const Off = 'Off';
}

class PassengerData {
  public $FirstName; // string
  public $LastName; // string
  public $PassengerId; // string
  public $Status; // string
  public $Passenger; // PassengerType
  public $Email; // string
  public $Phone; // string
}

class PassengerType {
  const Undefined = 'Undefined';
  const Adult = 'Adult';
  const Child = 'Child';
  const Infant = 'Infant';
  const Youth = 'Youth';
  const Student = 'Student';
  const SeniorCitizen = 'SeniorCitizen';
  const Military = 'Military';
}

class PhoneHedgeType {
  const Undefined = 'Undefined';
  const Low = 'Low';
  const Normal = 'Normal';
  const High = 'High';
  const Off = 'Off';
}

class ProductData {
  public $Code; // ProductCodeType
  public $Name; // string
  public $Risk; // ProductRiskType
  public $Sku; // string
  public $Quantity; // int
  public $UnitPrice; // decimal
}

class ProductCodeType {
  const Undefined = 'Undefined';
  const AdultContent = 'AdultContent';
  const Coupon = 'Coupon';
  const _Default = 'Default';
  const EletronicGood = 'EletronicGood';
  const EletronicSoftware = 'EletronicSoftware';
  const GiftCertificate = 'GiftCertificate';
  const HandlingOnly = 'HandlingOnly';
  const Service = 'Service';
  const ShippingAndHandling = 'ShippingAndHandling';
  const ShippingOnly = 'ShippingOnly';
  const Subscription = 'Subscription';
}

class ProductRiskType {
  const Undefined = 'Undefined';
  const Low = 'Low';
  const Normal = 'Normal';
  const High = 'High';
}

class TimeHedgeType {
  const Undefined = 'Undefined';
  const Low = 'Low';
  const Normal = 'Normal';
  const High = 'High';
  const Off = 'Off';
}

class VelocityHedgeType {
  const Undefined = 'Undefined';
  const Low = 'Low';
  const Normal = 'Normal';
  const High = 'High';
  const Off = 'Off';
}

class MerchantDefinedData {
  public $Field1; // string
  public $Field2; // string
  public $Field3; // string
  public $Field4; // string
  public $Field5; // string
  public $Field6; // string
  public $Field7; // string
  public $Field8; // string
  public $Field9; // string
  public $Field10; // string
  public $Field11; // string
  public $Field12; // string
  public $Field13; // string
  public $Field14; // string
  public $Field15; // string
}

class PurchaseTotalsData {
  public $Currency; // string
  public $GrandTotalAmount; // decimal
}

class ShipToData {
  public $City; // string
  public $Country; // string
  public $FirstName; // string
  public $LastName; // string
  public $PhoneNumber; // string
  public $PostalCode; // string
  public $ShippingMethod; // ShippingMethodType
  public $State; // string
  public $Street1; // string
  public $Street2; // string
}

class ShippingMethodType {
  const Undefined = 'Undefined';
  const SameDay = 'SameDay';
  const OneDay = 'OneDay';
  const TwoDay = 'TwoDay';
  const ThreeDay = 'ThreeDay';
  const LowCost = 'LowCost';
  const Pickup = 'Pickup';
  const Other = 'Other';
  const None = 'None';
}

class AntiFraudDocumentData {
  public $Cpf; // string
  public $Cnpj; // string
  public $Other; // string
}

/*
class FraudAnalysisResponse extends AbstractResponse {
  public $AntiFraudTransactionId; // guid
  public $TransactionStatusCode; // short
  public $TransactionStatusDescription; // string
  public $AntiFraudResponse; // AntiFraudResponse
  public $AuthorizeTransactionResponse; // AuthorizeTransactionResponse
}

class AbstractResponse {
  public $CorrelatedId; // guid
  public $Success; // boolean
  public $ErrorReportCollection; // ArrayOfErrorReport
}

class ErrorReport {
  public $ErrorCode; // short
  public $ErrorMessage; // string
}

class AntiFraudResponse {
  public $AfsReply; // AfsReplyData
  public $Decision; // string
  public $DecisionReply; // DecisionReplyData
  public $InvalidFieldCollection; // ArrayOfString
  public $MerchantReferenceCode; // string
  public $MissingFieldCollection; // ArrayOfString
  public $ReasonCode; // int
  public $RequestId; // string
  public $RequestToken; // string
}

class AfsReplyData {
  public $AddressInfoCode; // string
  public $AfsFactorCode; // string
  public $AfsResult; // int
  public $BinCountry; // string
  public $CardAccount; // CardAccountType
  public $CardIssuer; // string
  public $CardScheme; // CardSchemeType
  public $ConsumerLocalTime; // string
  public $DeviceFingerPrintData; // DeviceFingerprintData
  public $HostSeverity; // int
  public $HotlistInfoCode; // string
  public $IdentityInfoCode; // string
  public $InternetInfoCode; // string
  public $IpCity; // string
  public $IpCountry; // string
  public $IpRoutingMethod; // IpRoutingMethodType
  public $IpState; // string
  public $PhoneInfoCode; // string
  public $ReasonCode; // int
  public $ScoreModelUsed; // string
  public $SuspiciousInfoCode; // string
  public $VelocityInfoCode; // string
}

class CardAccountType {
  const Undefined = 'Undefined';
  const Consumer = 'Consumer';
  const Corporate = 'Corporate';
}

class CardSchemeType {
  const Undefined = 'Undefined';
  const MaestroInternational = 'MaestroInternational';
  const MaestroUkDomestic = 'MaestroUkDomestic';
  const MastercardCredit = 'MastercardCredit';
  const MastercardDebit = 'MastercardDebit';
  const VisaCredit = 'VisaCredit';
  const VisaDebit = 'VisaDebit';
  const VisaElectron = 'VisaElectron';
}

class DeviceFingerprintData {
  public $CookiesEnabled; // string
  public $FlashEnabled; // string
  public $Hash; // string
  public $ImagesEnabled; // string
  public $JavascriptEnabled; // string
  public $ProxyIPAddress; // string
  public $ProxyIPAddressActivities; // string
  public $ProxyIPAddressAttributes; // string
  public $ProxyServerType; // string
  public $TrueIPAddress; // string
  public $TrueIPAddressActivities; // string
  public $TrueIPAddressAttributes; // string
  public $TrueIPAddressCity; // string
  public $TrueIPAddressCountry; // string
  public $SmartID; // string
  public $SmartIDConfidenceLevel; // string
  public $ScreenResolution; // string
  public $BrowserLanguage; // string
}

class IpRoutingMethodType {
  const Undefined = 'Undefined';
  const Anonymizer = 'Anonymizer';
  const AolBased = 'AolBased';
  const CacheProxy = 'CacheProxy';
  const Fixed = 'Fixed';
  const InternationalProxy = 'InternationalProxy';
  const MobileGateway = 'MobileGateway';
  const Pop = 'Pop';
  const RegionalProxy = 'RegionalProxy';
  const Satellite = 'Satellite';
  const SuperPop = 'SuperPop';
}

class DecisionReplyData {
  public $ActiveProfileReply; // ActiveProfileReplyData
  public $CasePriority; // int
  public $VelocityInfoCode; // string
}

class ActiveProfileReplyData {
  public $SelectedBy; // string
  public $Name; // string
  public $DestinationQueue; // string
  public $RulesTriggered; // RulesTriggeredData
}

class RulesTriggeredData {
  public $RuleResultItemCollection; // ArrayOfRuleResultItemData
}

class RuleResultItemData {
  public $RuleNumber; // int
  public $Decision; // string
  public $Evaluation; // EvaluationType
  public $Name; // string
}

class EvaluationType {
  const Undefined = 'Undefined';
  const True = 'True';
  const False = 'False';
  const InsufficientData = 'InsufficientData';
  const Error = 'Error';
}

class FraudAnalysisTransactionDetails {
  public $request; // FraudAnalysisTransactionDetailsRequest
}

class FraudAnalysisTransactionDetailsRequest {
  public $MerchantId; // guid
  public $AntiFraudTransactionId; // guid
}

class FraudAnalysisTransactionDetailsResponse {
  public $FraudAnalysisTransactionDetailsResult; // FraudAnalysisTransactionDetailsResponse
}

class FraudAnalysisTransactionDetailsResponse {
  public $AntiFraudMerchantId; // guid
  public $AntiFraudTransactionId; // guid
  public $AntiFraudTransactionStatusCode; // short
  public $AntiFraudReceiveDate; // dateTime
  public $AntiFraudStatusLastUpdateDate; // dateTime
  public $AntiFraudAnalysisScore; // int
  public $BraspagTransactionId; // guid
  public $MerchantOrderId; // string
  public $FraudAnalysisRequestParameterCollection; // ArrayOfFraudAnalysisRequestParameter
  public $FraudAnalysisResponseParameterCollection; // ArrayOfFraudAnalysisResponseParameter
}

class FraudAnalysisRequestParameter {
  public $FieldName; // string
  public $FieldValue; // string
}

class FraudAnalysisResponseParameter {
  public $FieldName; // string
  public $FieldValue; // string
}

class AuthorizeTransactionRequest {
  public $OrderData; // OrderDataRequest
  public $CustomerData; // CustomerDataRequest
  public $PaymentDataCollection; // ArrayOfPaymentDataRequest
}

class AbstractRequest {
  public $RequestId; // guid
  public $Version; // string
}

class CaptureCreditCardTransactionRequest {
  public $MerchantId; // guid
  public $TransactionDataCollection; // ArrayOfTransactionDataRequest
}

class TransactionDataRequest {
  public $BraspagTransactionId; // guid
  public $Amount; // long
}

class VoidCreditCardTransactionRequest {
  public $MerchantId; // guid
  public $TransactionDataCollection; // ArrayOfTransactionDataRequest
}

class OrderDataRequest {
  public $MerchantId; // guid
  public $OrderId; // string
  public $BraspagOrderId; // guid
}

class CustomerDataRequest {
  public $CustomerIdentity; // string
  public $CustomerName; // string
  public $CustomerEmail; // string
  public $CustomerAddressData; // AddressDataRequest
  public $DeliveryAddressData; // AddressDataRequest
}

class AddressDataRequest {
  public $Street; // string
  public $Number; // string
  public $Complement; // string
  public $District; // string
  public $ZipCode; // string
  public $City; // string
  public $State; // string
  public $Country; // string
}

class PaymentDataRequest {
  public $PaymentMethod; // short
  public $Amount; // long
  public $Currency; // string
  public $Country; // string
  public $AdditionalDataCollection; // ArrayOfAdditionalDataRequest
}

class AdditionalDataRequest {
  public $Name; // string
  public $Value; // string
}

class OneBuyDataRequest {
  public $IdOneBuy; // string
  public $TokenOneBuy; // string
  public $NumberOfPayments; // short
  public $PaymentPlan; // unsignedByte
}

class BoletoDataRequest {
  public $BoletoNumber; // string
  public $BoletoInstructions; // string
  public $BoletoExpirationDate; // string
}

class CreditCardDataRequest {
  public $ServiceTaxAmount; // long
  public $NumberOfPayments; // short
  public $PaymentPlan; // unsignedByte
  public $TransactionType; // unsignedByte
  public $CardHolder; // string
  public $CardNumber; // string
  public $CardSecurityCode; // string
  public $CardExpirationDate; // string
  public $CreditCardToken; // guid
  public $SaveCreditCard; // boolean
}

class AuthorizeTransactionResponse {
  public $OrderData; // OrderDataResponse
  public $PaymentDataCollection; // ArrayOfPaymentDataResponse
}

class AbstractResponse {
  public $CorrelationId; // guid
  public $Success; // boolean
  public $ErrorReportDataCollection; // ArrayOfErrorReportDataResponse
}

class ErrorReportDataResponse {
  public $ErrorCode; // string
  public $ErrorMessage; // string
}

class CaptureCreditCardTransactionResponse {
  public $TransactionDataCollection; // ArrayOfTransactionDataResponse
}

class TransactionDataResponse {
  public $BraspagTransactionId; // guid
  public $AcquirerTransactionId; // string
  public $Amount; // long
  public $AuthorizationCode; // string
  public $ReturnCode; // string
  public $ReturnMessage; // string
  public $Status; // unsignedByte
}

class VoidCreditCardTransactionResponse {
  public $TransactionDataCollection; // ArrayOfTransactionDataResponse
}

class OrderDataResponse {
  public $OrderId; // string
  public $BraspagOrderId; // guid
}

class PaymentDataResponse {
  public $BraspagTransactionId; // guid
  public $PaymentMethod; // short
  public $Amount; // long
}

class BoletoDataResponse {
  public $BoletoNumber; // string
  public $BoletoExpirationDate; // string
  public $BoletoUrl; // string
  public $BarCodeNumber; // string
  public $Assignor; // string
  public $Message; // string
}

class CreditCardDataResponse {
  public $AcquirerTransactionId; // string
  public $AuthorizationCode; // string
  public $ReturnCode; // string
  public $ReturnMessage; // string
  public $Status; // unsignedByte
  public $CreditCardToken; // guid
}

class OneBuyDataResponse {
  public $AuthorizationCode; // string
  public $ReturnCode; // string
  public $ReturnMessage; // string
  public $Status; // unsignedByte
}
*/


/**
 * AntiFraud class
 *
 *
 *
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class AntiFraud extends SoapClient {

  private static $classmap = array(
                                    'FraudAnalysis' => 'FraudAnalysis',
                                    'FraudAnalysisRequest' => 'FraudAnalysisRequest',
                                    'AbstractAntiFraudRequest' => 'AbstractAntiFraudRequest',
                                    'AbstractRequest' => 'AbstractRequest',
                                    'AntiFraudSequenceType' => 'AntiFraudSequenceType',
                                    'AntiFraudRequest' => 'AntiFraudRequest',
                                    'BankInfoData' => 'BankInfoData',
                                    'BillToData' => 'BillToData',
                                    'CardData' => 'CardData',
                                    'CardType' => 'CardType',
                                    'DecisionManagerData' => 'DecisionManagerData',
                                    'TravelData' => 'TravelData',
                                    'TravelLegData' => 'TravelLegData',
                                    'FundTransferData' => 'FundTransferData',
                                    'InvoiceHeaderData' => 'InvoiceHeaderData',
                                    'TenderType' => 'TenderType',
                                    'ItemData' => 'ItemData',
                                    'GiftCategoryType' => 'GiftCategoryType',
                                    'HostHedgeType' => 'HostHedgeType',
                                    'NonSensicalHedgeType' => 'NonSensicalHedgeType',
                                    'ObscenitiesHedgeType' => 'ObscenitiesHedgeType',
                                    'PassengerData' => 'PassengerData',
                                    'PassengerType' => 'PassengerType',
                                    'PhoneHedgeType' => 'PhoneHedgeType',
                                    'ProductData' => 'ProductData',
                                    'ProductCodeType' => 'ProductCodeType',
                                    'ProductRiskType' => 'ProductRiskType',
                                    'TimeHedgeType' => 'TimeHedgeType',
                                    'VelocityHedgeType' => 'VelocityHedgeType',
                                    'MerchantDefinedData' => 'MerchantDefinedData',
                                    'PurchaseTotalsData' => 'PurchaseTotalsData',
                                    'ShipToData' => 'ShipToData',
                                    'ShippingMethodType' => 'ShippingMethodType',
                                    'AntiFraudDocumentData' => 'AntiFraudDocumentData',
                                    /*'FraudAnalysisResponse' => 'FraudAnalysisResponse',
                                    'AbstractResponse' => 'AbstractResponse',
                                    'ErrorReport' => 'ErrorReport',
                                    'AntiFraudResponse' => 'AntiFraudResponse',
                                    'AfsReplyData' => 'AfsReplyData',
                                    'CardAccountType' => 'CardAccountType',
                                    'CardSchemeType' => 'CardSchemeType',
                                    'DeviceFingerprintData' => 'DeviceFingerprintData',
                                    'IpRoutingMethodType' => 'IpRoutingMethodType',
                                    'DecisionReplyData' => 'DecisionReplyData',
                                    'ActiveProfileReplyData' => 'ActiveProfileReplyData',
                                    'RulesTriggeredData' => 'RulesTriggeredData',
                                    'RuleResultItemData' => 'RuleResultItemData',
                                    'EvaluationType' => 'EvaluationType',
                                    'FraudAnalysisTransactionDetails' => 'FraudAnalysisTransactionDetails',
                                    'FraudAnalysisTransactionDetailsRequest' => 'FraudAnalysisTransactionDetailsRequest',
                                    'FraudAnalysisTransactionDetailsResponse' => 'FraudAnalysisTransactionDetailsResponse',
                                    'FraudAnalysisTransactionDetailsResponse' => 'FraudAnalysisTransactionDetailsResponse',
                                    'FraudAnalysisRequestParameter' => 'FraudAnalysisRequestParameter',
                                    'FraudAnalysisResponseParameter' => 'FraudAnalysisResponseParameter',
                                    'guid' => 'guid',
                                    'AuthorizeTransactionRequest' => 'AuthorizeTransactionRequest',
                                    'AbstractRequest' => 'AbstractRequest',
                                    'CaptureCreditCardTransactionRequest' => 'CaptureCreditCardTransactionRequest',
                                    'TransactionDataRequest' => 'TransactionDataRequest',
                                    'VoidCreditCardTransactionRequest' => 'VoidCreditCardTransactionRequest',
                                    'OrderDataRequest' => 'OrderDataRequest',
                                    'CustomerDataRequest' => 'CustomerDataRequest',
                                    'AddressDataRequest' => 'AddressDataRequest',
                                    'PaymentDataRequest' => 'PaymentDataRequest',
                                    'AdditionalDataRequest' => 'AdditionalDataRequest',
                                    'OneBuyDataRequest' => 'OneBuyDataRequest',
                                    'BoletoDataRequest' => 'BoletoDataRequest',
                                    'CreditCardDataRequest' => 'CreditCardDataRequest',
                                    'AuthorizeTransactionResponse' => 'AuthorizeTransactionResponse',
                                    'AbstractResponse' => 'AbstractResponse',
                                    'ErrorReportDataResponse' => 'ErrorReportDataResponse',
                                    'CaptureCreditCardTransactionResponse' => 'CaptureCreditCardTransactionResponse',
                                    'TransactionDataResponse' => 'TransactionDataResponse',
                                    'VoidCreditCardTransactionResponse' => 'VoidCreditCardTransactionResponse',
                                    'OrderDataResponse' => 'OrderDataResponse',
                                    'PaymentDataResponse' => 'PaymentDataResponse',
                                    'BoletoDataResponse' => 'BoletoDataResponse',
                                    'CreditCardDataResponse' => 'CreditCardDataResponse',
                                    'OneBuyDataResponse' => 'OneBuyDataResponse',*/
                                   );

  public function AntiFraud($wsdl = "https://homologacao.braspag.com.br/AntiFraudeWS/AntiFraud.asmx?WSDL", $options = array()) {
    foreach(self::$classmap as $key => $value) {
      if(!isset($options['classmap'][$key])) {
        $options['classmap'][$key] = $value;
      }
    }
    parent::__construct($wsdl, $options);
  }

  // /**
  //  * Performs a fraud analysis operation.
  //  *
  //  * @param FraudAnalysis $parameters
  //  * @return FraudAnalysisResponse
  //  */
  // public function FraudAnalysis(FraudAnalysis $parameters) {
  //   try {
  //     return $this->__soapCall('FraudAnalysis', array($parameters),       array(
  //           'uri' => 'http://www.braspag.com.br/antifraud/',
  //           'soapaction' => ''
  //          )
  //     );
  //   } catch (Exception $e) {
  //     // print('<pre>');
  //     // print_r($parameters);
  //     // print('</pre>'); die();

  //     header("Content-Type: application/xml; charset=UTF-8");

  //     $arr = (array) $parameters; 
  //     print_r(XMLSerializer::generateValidXmlFromArray($arr)); die();
  //   }
  // }
  
  /**
   * Performs a fraud analysis operation.
   *
   * @param FraudAnalysis $parameters
   * @return FraudAnalysisResponse
   */
  public function FraudAnalysis(FraudAnalysis $parameters) {
    return $this->__soapCall('FraudAnalysis', array($parameters),       array(
            'uri' => 'http://www.braspag.com.br/antifraud/',
            'soapaction' => ''
           )
      );
  }
}

?>
