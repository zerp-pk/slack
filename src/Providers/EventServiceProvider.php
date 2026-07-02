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
use Workdo\Appointment\Events\AppointmentStatus;
use Workdo\Appointment\Events\CreateAppointment;
use Workdo\CleaningManagement\Events\CreateCleaningBooking;
use Workdo\CleaningManagement\Events\CreateCleaningInvoice;
use Workdo\CleaningManagement\Events\CreateCleaningTeam;
use Workdo\CMMS\Events\CreateCmmsPos;
use Workdo\CMMS\Events\CreateComponent;
use Workdo\CMMS\Events\CreateLocation;
use Workdo\CMMS\Events\CreatePreventiveMaintenance;
use Workdo\CMMS\Events\CreateSupplier;
use Workdo\CMMS\Events\CreateWorkOrder;
use Workdo\CMMS\Events\CreateWorkrequest;
use Zerp\Contract\Events\CreateContract;
use Workdo\Documents\Events\CreateDocument;
use Workdo\FixEquipment\Events\CreateFixEquipmentAccessory;
use Workdo\FixEquipment\Events\CreateFixEquipmentAsset;
use Workdo\FixEquipment\Events\CreateFixEquipmentAudit;
use Workdo\FixEquipment\Events\CreateFixEquipmentComponent;
use Workdo\FixEquipment\Events\CreateFixEquipmentConsumable;
use Workdo\FixEquipment\Events\CreateFixEquipmentLicense;
use Workdo\FixEquipment\Events\CreateFixEquipmentLocation;
use Workdo\FixEquipment\Events\CreateFixEquipmentMaintenance;
use Zerp\FormBuilder\Events\CreateForm;
use Zerp\FormBuilder\Events\FormConverted;
use Workdo\HospitalManagement\Events\CreateHospitalAppointment;
use Workdo\HospitalManagement\Events\CreateHospitalDoctor;
use Workdo\HospitalManagement\Events\CreateHospitalMedicine;
use Workdo\HospitalManagement\Events\CreateHospitalPatient;
use Zerp\Hrm\Events\CreateAward;
use Workdo\InnovationCenter\Events\CreateCategory;
use Workdo\InnovationCenter\Events\CreateChallenge;
use Workdo\InnovationCenter\Events\CreateCreativity;
use Workdo\Internalknowledge\Events\CreateInternalknowledgeArticle;
use Workdo\Internalknowledge\Events\CreateInternalknowledgeBook;
use Zerp\Lead\Events\CreateDeal;
use Zerp\Lead\Events\CreateLead;
use Zerp\Lead\Events\DealMoved;
use Zerp\Lead\Events\LeadConvertDeal;
use Zerp\Lead\Events\LeadMoved;
use Workdo\MachineRepairManagement\Events\CreateMachine;
use Workdo\MachineRepairManagement\Events\CreateMachineRepairRequest;
use Workdo\Notes\Events\CreateNote;
use Workdo\Portfolio\Events\CreatePortfolio;
use Zerp\Recruitment\Events\ConvertOfferToEmployee;
use Zerp\Recruitment\Events\CreateCandidate;
use Zerp\Recruitment\Events\CreateInterview;
use Zerp\Recruitment\Events\CreateJobPosting;
use Workdo\Retainer\Events\CreateRetainer;
use Workdo\Retainer\Events\CreateRetainerPayment;
use Workdo\Sales\Events\CreateSalesMeeting;
use Workdo\Sales\Events\CreateSalesOrder;
use Workdo\Sales\Events\CreateSalesQuote;
use Workdo\School\Events\CreateAdmission;
use Workdo\School\Events\CreateClassTimetable;
use Workdo\School\Events\CreateHomework;
use Workdo\School\Events\CreateParent;
use Workdo\School\Events\CreateStudent;
use Workdo\School\Events\CreateSubject;
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
use Workdo\Spreadsheet\Events\CreateSpreadsheet;
use Zerp\Taskly\Events\CreateProject;
use Zerp\Taskly\Events\CreateProjectBug;
use Zerp\Taskly\Events\CreateProjectMilestone;
use Zerp\Taskly\Events\CreateProjectTask;
use Zerp\Taskly\Events\CreateTaskComment;
use Zerp\Taskly\Events\UpdateProjectTaskStage;
use Zerp\Timesheet\Events\CreateTimesheet;
use Workdo\TimeTracker\Events\CreateTimeTracker;
use Workdo\ToDo\Events\CompleteToDo;
use Workdo\ToDo\Events\CreateToDo;
use Zerp\Training\Events\CreateTrainer;
use Workdo\VisitorManagement\Events\CreateVisitor;
use Workdo\WordpressWoocommerce\Events\CreateWoocommerceProduct;
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
