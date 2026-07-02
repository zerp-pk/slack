<?php

namespace Zerp\Slack\Providers;

use App\Events\CreatePurchaseInvoice;
use App\Events\CreateSalesInvoice;
use App\Events\CreateSalesProposal;
use App\Events\CreateUser;
use App\Events\CreateWarehouse;
use App\Events\PostSalesInvoice;
use App\Events\SentSalesProposal;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Zerp\Account\Events\CreateCustomer;
use Zerp\Account\Events\CreateRevenue;
use Zerp\Account\Events\CreateVendor;
use Zerp\Appointment\Events\AppointmentStatus;
use Zerp\Appointment\Events\CreateAppointment;
use Zerp\CleaningManagement\Events\CreateCleaningBooking;
use Zerp\CleaningManagement\Events\CreateCleaningInvoice;
use Zerp\CleaningManagement\Events\CreateCleaningTeam;
use Zerp\CMMS\Events\CreateCmmsPos;
use Zerp\CMMS\Events\CreateComponent;
use Zerp\CMMS\Events\CreateLocation;
use Zerp\CMMS\Events\CreatePreventiveMaintenance;
use Zerp\CMMS\Events\CreateSupplier;
use Zerp\CMMS\Events\CreateWorkOrder;
use Zerp\CMMS\Events\CreateWorkrequest;
use Zerp\Contract\Events\CreateContract;
use Zerp\Documents\Events\CreateDocument;
use Zerp\FixEquipment\Events\CreateFixEquipmentAccessory;
use Zerp\FixEquipment\Events\CreateFixEquipmentAsset;
use Zerp\FixEquipment\Events\CreateFixEquipmentAudit;
use Zerp\FixEquipment\Events\CreateFixEquipmentComponent;
use Zerp\FixEquipment\Events\CreateFixEquipmentConsumable;
use Zerp\FixEquipment\Events\CreateFixEquipmentLicense;
use Zerp\FixEquipment\Events\CreateFixEquipmentLocation;
use Zerp\FixEquipment\Events\CreateFixEquipmentMaintenance;
use Zerp\FormBuilder\Events\CreateForm;
use Zerp\FormBuilder\Events\FormConverted;
use Zerp\HospitalManagement\Events\CreateHospitalAppointment;
use Zerp\HospitalManagement\Events\CreateHospitalDoctor;
use Zerp\HospitalManagement\Events\CreateHospitalMedicine;
use Zerp\HospitalManagement\Events\CreateHospitalPatient;
use Zerp\Hrm\Events\CreateAward;
use Zerp\InnovationCenter\Events\CreateCategory;
use Zerp\InnovationCenter\Events\CreateChallenge;
use Zerp\InnovationCenter\Events\CreateCreativity;
use Zerp\Internalknowledge\Events\CreateInternalknowledgeArticle;
use Zerp\Internalknowledge\Events\CreateInternalknowledgeBook;
use Zerp\Lead\Events\CreateDeal;
use Zerp\Lead\Events\CreateLead;
use Zerp\Lead\Events\DealMoved;
use Zerp\Lead\Events\LeadConvertDeal;
use Zerp\Lead\Events\LeadMoved;
use Zerp\MachineRepairManagement\Events\CreateMachine;
use Zerp\MachineRepairManagement\Events\CreateMachineRepairRequest;
use Zerp\Notes\Events\CreateNote;
use Zerp\Portfolio\Events\CreatePortfolio;
use Zerp\Recruitment\Events\ConvertOfferToEmployee;
use Zerp\Recruitment\Events\CreateCandidate;
use Zerp\Recruitment\Events\CreateInterview;
use Zerp\Recruitment\Events\CreateJobPosting;
use Zerp\Retainer\Events\CreateRetainer;
use Zerp\Retainer\Events\CreateRetainerPayment;
use Zerp\Sales\Events\CreateSalesMeeting;
use Zerp\Sales\Events\CreateSalesOrder;
use Zerp\Sales\Events\CreateSalesQuote;
use Zerp\School\Events\CreateAdmission;
use Zerp\School\Events\CreateClassTimetable;
use Zerp\School\Events\CreateHomework;
use Zerp\School\Events\CreateParent;
use Zerp\School\Events\CreateStudent;
use Zerp\School\Events\CreateSubject;
use Zerp\Slack\Listeners\AppointmentStatusLis;
use Zerp\Slack\Listeners\CompleteToDoLis;
use Zerp\Slack\Listeners\ConvertOfferToEmployeeLis;
use Zerp\Slack\Listeners\CreateAdmissionLis;
use Zerp\Slack\Listeners\CreateAppointmentLis;
use Zerp\Slack\Listeners\CreateAwardLis;
use Zerp\Slack\Listeners\CreateCandidateLis;
use Zerp\Slack\Listeners\CreateCategoryLis;
use Zerp\Slack\Listeners\CreateChallengeLis;
use Zerp\Slack\Listeners\CreateClassTimetableLis;
use Zerp\Slack\Listeners\CreateCleaningBookingLis;
use Zerp\Slack\Listeners\CreateCleaningInvoiceLis;
use Zerp\Slack\Listeners\CreateCleaningTeamLis;
use Zerp\Slack\Listeners\CreateCmmsPosLis;
use Zerp\Slack\Listeners\CreateComponentLis;
use Zerp\Slack\Listeners\CreateContractLis;
use Zerp\Slack\Listeners\CreateCourseLis;
use Zerp\Slack\Listeners\CreateCreativityLis;
use Zerp\Slack\Listeners\CreateCustomerLis;
use Zerp\Slack\Listeners\CreateCustomPageLis;
use Zerp\Slack\Listeners\CreateDealLis;
use Zerp\Slack\Listeners\CreateDocumentLis;
use Zerp\Slack\Listeners\CreateFixEquipmentAccessoryLis;
use Zerp\Slack\Listeners\CreateFixEquipmentAssetLis;
use Zerp\Slack\Listeners\CreateFixEquipmentAuditLis;
use Zerp\Slack\Listeners\CreateFixEquipmentComponentLis;
use Zerp\Slack\Listeners\CreateFixEquipmentConsumableLis;
use Zerp\Slack\Listeners\CreateFixEquipmentLicenseLis;
use Zerp\Slack\Listeners\CreateFixEquipmentLocationLis;
use Zerp\Slack\Listeners\CreateFixEquipmentMaintenanceLis;
use Zerp\Slack\Listeners\CreateFormLis;
use Zerp\Slack\Listeners\CreateHistoryLis;
use Zerp\Slack\Listeners\CreateHomeworkLis;
use Zerp\Slack\Listeners\CreateHospitalAppointmentLis;
use Zerp\Slack\Listeners\CreateHospitalDoctorLis;
use Zerp\Slack\Listeners\CreateHospitalMedicineLis;
use Zerp\Slack\Listeners\CreateHospitalPatientLis;
use Zerp\Slack\Listeners\CreateInternalknowledgeArticleLis;
use Zerp\Slack\Listeners\CreateInternalknowledgeBookLis;
use Zerp\Slack\Listeners\CreateInterviewLis;
use Zerp\Slack\Listeners\CreateJobPostingLis;
use Zerp\Slack\Listeners\CreateLeadLis;
use Zerp\Slack\Listeners\CreateLocationLis;
use Zerp\Slack\Listeners\CreateMachineLis;
use Zerp\Slack\Listeners\CreateMachineRepairRequestLis;
use Zerp\Slack\Listeners\CreateNoteLis;
use Zerp\Slack\Listeners\CreateOrderLis;
use Zerp\Slack\Listeners\CreateParentLis;
use Zerp\Slack\Listeners\CreatePortfolioLis;
use Zerp\Slack\Listeners\CreatePreventiveMaintenanceLis;
use Zerp\Slack\Listeners\CreateProjectBugLis;
use Zerp\Slack\Listeners\CreateProjectLis;
use Zerp\Slack\Listeners\CreateProjectMilestoneLis;
use Zerp\Slack\Listeners\CreateProjectTaskLis;
use Zerp\Slack\Listeners\CreatePurchaseInvoiceLis;
use Zerp\Slack\Listeners\CreateRetainerLis;
use Zerp\Slack\Listeners\CreateRetainerPaymentLis;
use Zerp\Slack\Listeners\CreateRevenueLis;
use Zerp\Slack\Listeners\CreateSalesInvoiceLis;
use Zerp\Slack\Listeners\CreateSalesMeetingLis;
use Zerp\Slack\Listeners\CreateSalesOrderLis;
use Zerp\Slack\Listeners\CreateSalesProposalLis;
use Zerp\Slack\Listeners\CreateSalesQuoteLis;
use Zerp\Slack\Listeners\CreateSpreadsheetLis;
use Zerp\Slack\Listeners\CreateStudentLis;
use Zerp\Slack\Listeners\CreateSubjectLis;
use Zerp\Slack\Listeners\CreateSupplierLis;
use Zerp\Slack\Listeners\CreateTaskCommentLis;
use Zerp\Slack\Listeners\CreateTimesheetLis;
use Zerp\Slack\Listeners\CreateTimeTrackerLis;
use Zerp\Slack\Listeners\CreateToDoLis;
use Zerp\Slack\Listeners\CreateTrainerLis;
use Zerp\Slack\Listeners\CreateUserLis;
use Zerp\Slack\Listeners\CreateVendorLis;
use Zerp\Slack\Listeners\CreateVisitorLis;
use Zerp\Slack\Listeners\CreateWarehouseLis;
use Zerp\Slack\Listeners\CreateWoocommerceProductLis;
use Zerp\Slack\Listeners\CreateWorkorderLis;
use Zerp\Slack\Listeners\CreateWorkrequestLis;
use Zerp\Slack\Listeners\CreateZoommeetingLis;
use Zerp\Slack\Listeners\DealMovedLis;
use Zerp\Slack\Listeners\FormConvertedLis;
use Zerp\Slack\Listeners\LeadConvertDealLis;
use Zerp\Slack\Listeners\LeadMovedLis;
use Zerp\Slack\Listeners\PostSalesInvoiceLis;
use Zerp\Slack\Listeners\SentSalesProposalLis;
use Zerp\Slack\Listeners\UpdateProjectTaskStageLis;
use Zerp\Spreadsheet\Events\CreateSpreadsheet;
use Zerp\Taskly\Events\CreateProject;
use Zerp\Taskly\Events\CreateProjectBug;
use Zerp\Taskly\Events\CreateProjectMilestone;
use Zerp\Taskly\Events\CreateProjectTask;
use Zerp\Taskly\Events\CreateTaskComment;
use Zerp\Taskly\Events\UpdateProjectTaskStage;
use Zerp\Timesheet\Events\CreateTimesheet;
use Zerp\TimeTracker\Events\CreateTimeTracker;
use Zerp\ToDo\Events\CompleteToDo;
use Zerp\ToDo\Events\CreateToDo;
use Zerp\Training\Events\CreateTrainer;
use Zerp\VisitorManagement\Events\CreateVisitor;
use Zerp\WordpressWoocommerce\Events\CreateWoocommerceProduct;
use Zerp\ZoomMeeting\Events\CreateZoomMeeting;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CreateUser::class => [
            CreateUserLis::class,
        ],
        CreateSalesInvoice::class => [
            CreateSalesInvoiceLis::class
        ],
        PostSalesInvoice::class => [
            PostSalesInvoiceLis::class
        ],
        CreateSalesProposal::class => [
            CreateSalesProposalLis::class
        ],
        SentSalesProposal::class => [
            SentSalesProposalLis::class
        ],
        CreatePurchaseInvoice::class => [
            CreatePurchaseInvoiceLis::class
        ],
        CreateWarehouse::class => [
            CreateWarehouseLis::class
        ],
        CreateCustomer::class => [
            CreateCustomerLis::class
        ],
        CreateVendor::class => [
            CreateVendorLis::class
        ],
        CreateRevenue::class => [
            CreateRevenueLis::class
        ],
        CreateAppointment::class => [
            CreateAppointmentLis::class
        ],
        AppointmentStatus::class => [
            AppointmentStatusLis::class
        ],
        CreateWorkrequest::class => [
            CreateWorkrequestLis::class
        ],
        CreateSupplier::class => [
            CreateSupplierLis::class
        ],
        CreateCmmsPos::class => [
            CreateCmmsPosLis::class
        ],
        CreateWorkOrder::class => [
            CreateWorkorderLis::class
        ],
        CreateComponent::class => [
            CreateComponentLis::class
        ],
        CreateLocation::class => [
            CreateLocationLis::class
        ],
        CreatePreventiveMaintenance::class => [
            CreatePreventiveMaintenanceLis::class
        ],
        CreateContract::class => [
            CreateContractLis::class
        ],
        CreateAward::class => [
            CreateAwardLis::class,
        ],
        CreateLead::class => [
            CreateLeadLis::class
        ],
        LeadConvertDeal::class => [
            LeadConvertDealLis::class
        ],
        CreateDeal::class => [
            CreateDealLis::class
        ],
        LeadMoved::class => [
            LeadMovedLis::class
        ],
        DealMoved::class => [
            DealMovedLis::class
        ],
        CreateCandidate::class => [
            CreateCandidateLis::class
        ],
        CreateInterview::class => [
            CreateInterviewLis::class
        ],
        ConvertOfferToEmployee::class => [
            ConvertOfferToEmployeeLis::class
        ],
        CreateJobPosting::class => [
            CreateJobPostingLis::class
        ],
        CreateRetainer::class => [
            CreateRetainerLis::class
        ],
        CreateRetainerPayment::class => [
            CreateRetainerPaymentLis::class
        ],
        CreateSalesQuote::class => [
            CreateSalesQuoteLis::class
        ],
        CreateSalesOrder::class => [
            CreateSalesOrderLis::class
        ],
        CreateSalesMeeting::class => [
            CreateSalesMeetingLis::class
        ],
        CreateProject::class => [
            CreateProjectLis::class
        ],
        CreateProjectTask::class => [
            CreateProjectTaskLis::class
        ],
        CreateProjectBug::class => [
            CreateProjectBugLis::class
        ],
        CreateProjectMilestone::class => [
            CreateProjectMilestoneLis::class
        ],
        UpdateProjectTaskStage::class => [
            UpdateProjectTaskStageLis::class
        ],
        CreateTaskComment::class => [
            CreateTaskCommentLis::class
        ],
        CreateTrainer::class => [
            CreateTrainerLis::class
        ],
        CreateZoomMeeting::class => [
            CreateZoommeetingLis::class
        ],
        CreatePortfolio::class => [
            CreatePortfolioLis::class
        ],
        CreateSpreadsheet::class => [
            CreateSpreadsheetLis::class
        ],
        CreateFixEquipmentAccessory::class => [
            CreateFixEquipmentAccessoryLis::class
        ],
        CreateFixEquipmentAsset::class => [
            CreateFixEquipmentAssetLis::class
        ],
        CreateFixEquipmentAudit::class => [
            CreateFixEquipmentAuditLis::class
        ],
        CreateFixEquipmentComponent::class => [
            CreateFixEquipmentComponentLis::class
        ],
        CreateFixEquipmentConsumable::class => [
            CreateFixEquipmentConsumableLis::class
        ],
        CreateFixEquipmentLicense::class => [
            CreateFixEquipmentLicenseLis::class
        ],
        CreateFixEquipmentLocation::class => [
            CreateFixEquipmentLocationLis::class
        ],
        CreateFixEquipmentMaintenance::class => [
            CreateFixEquipmentMaintenanceLis::class
        ],
        CreateVisitor::class => [
            CreateVisitorLis::class
        ],
        CreateWoocommerceProduct::class => [
            CreateWoocommerceProductLis::class
        ],
        CreateAdmission::class => [
            CreateAdmissionLis::class
        ],
        CreateParent::class => [
            CreateParentLis::class
        ],
        CreateStudent::class => [
            CreateStudentLis::class
        ],
        CreateHomework::class => [
            CreateHomeworkLis::class
        ],
        CreateSubject::class => [
            CreateSubjectLis::class
        ],
        CreateClassTimetable::class => [
            CreateClassTimetableLis::class
        ],
        CreateCleaningTeam::class => [
            CreateCleaningTeamLis::class
        ],
        CreateCleaningBooking::class => [
            CreateCleaningBookingLis::class
        ],
        CreateCleaningInvoice::class => [
            CreateCleaningInvoiceLis::class
        ],
        CreateTimeTracker::class => [
            CreateTimeTrackerLis::class
        ],
        CreateMachine::class => [
            CreateMachineLis::class
        ],
        CreateMachineRepairRequest::class => [
            CreateMachineRepairRequestLis::class
        ],
        CreateHospitalDoctor::class => [
            CreateHospitalDoctorLis::class
        ],
        CreateHospitalPatient::class => [
            CreateHospitalPatientLis::class
        ],
        CreateHospitalAppointment::class => [
            CreateHospitalAppointmentLis::class
        ],
        CreateHospitalMedicine::class => [
            CreateHospitalMedicineLis::class
        ],
        CreateForm::class => [
            CreateFormLis::class
        ],
        FormConverted::class => [
            FormConvertedLis::class
        ],
        CreateTimesheet::class => [
            CreateTimesheetLis::class
        ],
        CreateNote::class => [
            CreateNoteLis::class
        ],
        CreateInternalknowledgeArticle::class => [
            CreateInternalknowledgeArticleLis::class
        ],
        CreateInternalknowledgeBook::class => [
            CreateInternalknowledgeBookLis::class
        ],
        CreateCreativity::class => [
            CreateCreativityLis::class
        ],
        CreateChallenge::class => [
            CreateChallengeLis::class
        ],
        CreateCategory::class => [
            CreateCategoryLis::class
        ],
        CreateToDo::class => [
            CreateToDoLis::class
        ],
        CompleteToDo::class => [
            CompleteToDoLis::class
        ],
        CreateDocument::class => [
            CreateDocumentLis::class
        ],

    ];
}
