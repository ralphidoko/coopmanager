<?php

namespace App\Http\Controllers;

use App\Member;
use App\User;
use Illuminate\Http\Request;

class AdminMembershipApplicationApprovalController extends Controller
{

    public function showMembershipApplication()
    {
        //get all members
        $userDetails = Member::where('certification',true)->get();

        return view('dashboard.admin.membershipApplication',compact('userDetails'));
    }

    public function showMembershipApplicationDetails($application_id)
    {
        $application = Member::where([['id',$application_id]])->firstOrFail();
        return view('dashboard.admin.membershipApproval',compact('application'));
    }

    public function showMembershipRenewalRequests()
    {
        $renewalRequests = User::where('membership_renewal_status','Request Submitted')->get();
        return view('dashboard.admin.membershipRenewal',compact('renewalRequests'));
    }

    public function showMembershipRenewalDetails($request_id)
    {
        $application = User::where('id',$request_id)->firstOrFail();
        return view('dashboard.admin.membershipRenewalApproval',compact('application'));
    }

    public function approveMembershipRenewalRequest(Request $request)
    {
       $approveRenewalRequest =  User::where('id',$request->application_id)->update([
            'membership_renewal_status' => 'Request Approved',
        ]);
       $unarchiveMember = Member::where('user_id',$request->application_id)->update([
           'membership_status' => 'Active'
       ]);
       //send email to the members
        if($approveRenewalRequest && $unarchiveMember){
            $data = ['success' => true, 'message'=> "Membership Renewal Request Approved"];
            return response()->json($data);
        }else{
            $data = ['warning' => true, 'message'=> "Something wrong with the approval"];
            return response()->json($data);
        }
    }

    public function approveMembershipApplication(Request $request)
    {
        if($request->sec_approve){
            return $this->secApproveMembership($request);
        }elseif ($request->chair_approve){
            return $this->chairApproveMembership($request);
        }elseif ($request->reject_loan){
            return $this->rejectMembership($request);
        }else{
            return $this->resetMembershipApplicationToDraft($request);
        }
    }

    private function secApproveMembership(Request $request)
    {
        $approvalCount = Member::where([['id',$request->application_id],['certification',1]])->firstOrFail();
        $approvalCount = $approvalCount->approval_count + 1;
        $secApproveMembership =  Member::where('id',$request->application_id)->update([
            'approval_count' => $approvalCount,
        ]);

        if($secApproveMembership){
            $data = ['success' => true, 'message'=> "Membership application approved by the Secretary"];
            return response()->json($data);
        }else{
            $data = ['warning' => true, 'message'=> "Something wrong with the approval"];
            return response()->json($data);
        }
    }

    private function chairApproveMembership(Request $request)
    {
        $memberShipCount = User::all()->count() - 1;
        $membershipID = sprintf('MN'."%'.04d",$memberShipCount+1);
        $approvalCount = Member::where([['id',$request->application_id],['certification',1]])->firstOrFail();
        $approvalCount = $approvalCount->approval_count + 1;
        $chairApproveMembership =  Member::where('id',$request->application_id)->update([
            'approval_count' => $approvalCount,
            'approval_status' => 'Approved',
            'membership_status' => 'Active',
            'member_id' => $membershipID,
        ]);

        //$userObject = User::find($request->staff_email);
        $applicationDetails = [
            'applicant_name' => $request->staff_name,
            'user_email' => $request->staff_email,
        ];

        //notify the applicant of membership approval
        (new MailController())->membershipApprovalNotifyMember($applicationDetails);

        if($chairApproveMembership){
            $data = ['success' => true, 'message'=> "Membership application approved by the President"];
            return response()->json($data);
        }else{
            $data = ['warning' => true, 'message'=> "Something wrong with the approval"];
            return response()->json($data);
        }
    }

    private function rejectMembership(Request $request)
    {
        //notify the applicant of application rejection
        $approvalCount = 0;
        $rejectMembership =  Member::where('id',$request->application_id)->update([
            'approval_count' => $approvalCount,
            'approval_status' => 'Rejected',
            'reason_for_rejection'  => $request->reason_for_rejection,
        ]);

        //$userObject = User::find($request->staff_email);
        $rejectionDetails = [
            'applicant_name' => $request->staff_name,
            'user_email' => $request->staff_email,
            'reason_for_rejection'  => $request->reason_for_rejection,

        ];

        (new MailController)->membershipApplicationRejectionNotification($rejectionDetails);
        if($rejectMembership){
            $data = ['warning' => true, 'message'=> "Membership application rejected"];
            return response()->json($data);
        }
    }

    private function resetMembershipApplicationToDraft(Request $request)
    {
        $approvalCount = 0;
        $revokeApplication =  Member::where('id',$request->application_id)->update([
            'approval_status' => 'Processing',
            'reason_for_rejection' => '',
            'approval_count' => $approvalCount,
        ]);
        if($revokeApplication){
            $data = ['success' => true, 'message'=> "Application reset to draft"];
            return response()->json($data);
        }

    }



}
