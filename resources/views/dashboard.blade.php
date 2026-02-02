@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid flow-container mt-4" style="font-size: 0.7rem;">
	<div class="row">
		<div class="col-9">
		
			<div class="border border-secondary p-3">
			
				<div class="text-center">
					<h6 class="opacity-50 section-title">VENDORS</h6>
				</div>
				
				
				<div class="container-fluid mt-3">
					<div class="row g-3 align-items-center">
					
						<div class="col-md-1">
							<a href="/purchase-orders" class="text-decoration-none ajax-link" title="Purchase Orders">
								<div class="card text-center hover-shadow cursor-pointer" id="po">
									<i class="bi bi-archive fs-1 text-success"></i>
									<span class="small-text">Purchase Orders</span>
								</div>
							</a>
						</div>
						
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>

						
						<div class="col-md-1">
							<a href="/purchase_receipts" class="text-decoration-none ajax-link" title="Receive Inventory">
								<div class="card text-center hover-shadow cursor-pointer" id="receive">
									<i class="bi bi-cash-stack fs-1 text-warning"></i>
									<span class="small-text">Receive Inventory</span>
								</div>
							</a>
						</div>
						
												<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						
						<div class="col-md-1">
							<a href="/purchase_bills" class="text-decoration-none ajax-link" title="Receive Inventory">
								<div class="card text-center hover-shadow cursor-pointer" id="enter-ai">
									<i class="bi bi-check2-square fs-1 text-primary"></i>
									<span class="small-text">Enter Bills Against Inventory</span>
								</div>
							</a>
						</div>
						
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						
						<div class="col-md-1">
							<div class="card text-center hover-shadow cursor-pointer">
								<i class="bi bi-archive fs-1 text-primary"></i>
								<span class="small-text">See Funding Options</span>
							</div>
						</div>
					
					</div>
				</div>
					
					
					
				<div class="container-fluid mt-5">
					<div class="row g-3 align-items-center">
					
						<div class="col-md-2"></div>
						
						<div class="col-md-1">
							<div class="card text-center hover-shadow cursor-pointer" id="enter">
								<i class="bi bi-receipt fs-1 text-primary"></i>
								<span class="small-text">Enter Bills</span>
							</div>
						</div>
						
						<div class="col-md-8"></div>
						
						<div class="col-md-1">
							<a href="/pay_bills" class="text-decoration-none ajax-link" title="Receive Inventory">
								<div class="card text-center hover-shadow cursor-pointer" id="pay">
									<i class="bi bi-cash-stack fs-1 text-primary"></i>
									<span class="small-text">Pay Bills</span>
								</div>
							</a>
						</div>
					
					</div>
				</div>
				
				
			
			</div>
			
			<!------ CUSTOMER ------>
			<div class="border border-secondary p-3">
			
				<div class="text-center">
					<h6 class="opacity-50 section-title">CUSTOMER</h6>
				</div>
				
				
				<div class="container-fluid mt-3">
					<div class="row g-3 align-items-center">
						<div class="col-md-1">
							<a href="/purchase-orders" class="text-decoration-none" title="Purchase Orders">
								<div class="card text-center hover-shadow cursor-pointer" id="salesorder">
									<i class="bi bi-receipt fs-1 text-primary"></i>
									<span class="small-text">Sales Order</span>
								</div>
							</a>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1" id="dirimoconnect"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
                        
												
						<div class="col-md-1">
							<div class="card text-center hover-shadow cursor-pointer" id="csr">
								<i class="bi bi-receipt-cutoff fs-1 text-warning"></i>
								<span class="small-text">Create States Receipts</span>
							</div>
						</div>
					</div>
				</div>
				
				<div class="container-fluid mt-5">
					<div class="row g-3 align-items-center">
						<div class="col-md-1">
							<div class="card text-center hover-shadow cursor-pointer" id="quotes">
								<i class="bi bi-file-earmark-text fs-1 text-success"></i>
								<span class="small-text">Quotes (Estimates)</span>
							</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<div class="card text-center hover-shadow cursor-pointer" id="creatinvoice">
								<i class="bi bi-file-earmark-text fs-1 text-primary"></i>
								<span class="small-text">Create Invoices</span>
							</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<div class="card text-center hover-shadow cursor-pointer" id="receivepayments">
								<i class="bi bi-cash-stack fs-1 text-success"></i>
								<span class="small-text">Receives Payments</span>
							</div>
						</div>
					</div>
				</div>
				<div class="container-fluid mt-5">
					<div class="row g-3 align-items-center">
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<div class="card text-center hover-shadow cursor-pointer" id="statementcharges">
								<i class="bi bi-receipt fs-1 text-success"></i>
								<span class="small-text">Statement Charges</span>
							</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<div class="card text-center hover-shadow cursor-pointer" id="statements">
								<i class="bi bi-receipt fs-1 text-primary"></i>
								<span class="small-text">Statements</span>
							</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-1">
							<div class="card text-center hover-shadow cursor-pointer" id="refundandcredits">
								<i class="bi bi-arrow-counterclockwise fs-1 text-success"></i>
								<span class="small-text">Refunds &amp; Credits</span>
							</div>
						</div>

					</div>
				</div>				
				
			</div>
			
			
			
			
		</div>
		
		<div class="col-3">
		
			<div class="border border-secondary p-3">
				<div class="text-center">
					<h6 class="opacity-50 section-title">COMPANY</h6>
				</div>
				<div class="container-fluid mt-3">
					<div class="row g-3 align-items-center">
					
						<div class="col-md-6">
							<div class="card text-center hover-shadow cursor-pointer" id="po">
								<i class="bi bi-diagram-3 fs-1 text-primary"></i>
								<span class="small-text">Chart of Accounts</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card text-center hover-shadow cursor-pointer" id="po">
								<i class="bi bi-clipboard-data fs-1 text-primary"></i>
								<span class="small-text">Inventory Activities</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card text-center hover-shadow cursor-pointer" id="po">
								<i class="bi bi-tags fs-1 text-warning"></i>
								<span class="small-text">Items &amp; Services</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card text-center hover-shadow cursor-pointer" id="po">
								<i class="bi bi-check2-circle fs-1 text-primary"></i>
								<span class="small-text">Order Checks</span>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="card text-center hover-shadow cursor-pointer" id="po">
								<i class="bi bi-people fs-1 text-primary"></i>
								<span class="small-text">Intercompany</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card text-center hover-shadow cursor-pointer" id="po">
								<i class="bi bi-calendar fs-1 text-primary"></i>
								<span class="small-text">Calendar</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="border border-secondary p-3">
				<div class="text-center">
					<h6 class="opacity-50 section-title">BANKING</h6>
				</div>
				<div class="container-fluid mt-3">
					<div class="row g-3 align-items-center">
						
						<div class="col-md-12"></div>
						<div class="col-md-12"></div>
						<div class="col-md-12"></div>
						<div class="col-md-12"></div>
						<div class="col-md-12"></div>
						<div class="col-md-12"></div>
						<div class="col-md-12"></div>
						<div class="col-md-12"></div>
						
						<div class="col-md-6">
							<div class="card text-center hover-shadow cursor-pointer" id="recordsdeposit">
								<i class="bi bi-cash-stack fs-1 text-warning"></i>
								<span class="small-text">Records Deposits</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card text-center hover-shadow cursor-pointer" id="reconcile">
								<i class="bi bi-check2-square fs-1 text-success"></i>
								<span class="small-text">Reconcile</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card text-center hover-shadow cursor-pointer" id="writechecks">
								<i class="bi bi-pencil fs-1 text-primary"></i>
								<span class="small-text">Write Checks</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card text-center hover-shadow cursor-pointer" id="checkregister">
								<i class="bi bi-journal-check fs-1 text-success"></i>
								<span class="small-text">Checks Register</span>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="card text-center hover-shadow cursor-pointer" id="">
								<i class="bi bi-people fs-1 text-primary"></i>
								<span class="small-text">Intercompany</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>

@endsection

@push('styles')
<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') }}" rel="stylesheet">
<style>
.flow-container { position: relative; }
.flow-line { position: absolute; height: 2px; background: rgba(0,0,0,.45); transform-origin: left center; }
.flow-line.arrow::after { content:""; position:absolute; right:-8px; top:-5px; border-top:6px solid transparent; border-bottom:6px solid transparent; border-left:8px solid rgba(0,0,0,.7); }
.flow-line.arrow-up::after { content:""; position:absolute; top:-8px; left:-5px; border-left:6px solid transparent; border-right:6px solid transparent; border-bottom:8px solid rgba(0,0,0,.7); }
.flow-line.arrow-down::after { content:""; position:absolute; bottom:-8px; left:-5px; border-left:6px solid transparent; border-right:6px solid transparent; border-top:8px solid rgba(0,0,0,.7); }
.hover-shadow { transition: all 0.3s ease; cursor:pointer; }
.hover-shadow:hover { box-shadow:0 8px 16px rgba(0,0,0,0.3); transform:translateY(-4px); }
.section-title { font-weight:600; letter-spacing:1px; text-transform:uppercase; color:#495057; background: rgba(0,123,255,.1); padding:4px 12px; border-radius:12px; display:inline-block; }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
function drawLine(fromId,toId,arrow=true){
    const from=document.getElementById(fromId),to=document.getElementById(toId),c=document.querySelector('.flow-container');
    if(!from||!to||!c)return;
    const a=from.getBoundingClientRect(),b=to.getBoundingClientRect(),cc=c.getBoundingClientRect();
    const x1=a.right-cc.left,y1=a.top+a.height/2-cc.top;
    const x2=b.left-cc.left,y2=b.top+b.height/2-cc.top;
    const length=Math.hypot(x2-x1,y2-y1),angle=Math.atan2(y2-y1,x2-x1)*180/Math.PI;
    const line=document.createElement('div');line.className='flow-line'+(arrow?' arrow':'');line.style.width=length+'px';line.style.left=x1+'px';line.style.top=y1+'px';line.style.transform=`rotate(${angle}deg)`;c.appendChild(line);
}

function drawDownArrow(fromId,toId){
    const from=document.getElementById(fromId),to=document.getElementById(toId),c=document.querySelector('.flow-container');
    if(!from||!to||!c)return;
    const f=from.getBoundingClientRect(),t=to.getBoundingClientRect(),cc=c.getBoundingClientRect();
    const x=f.left+f.width/2-cc.left;
    const startY=f.bottom-cc.top,endY=t.top-cc.top;
    const line=document.createElement('div');line.className='flow-line arrow-down';line.style.width='2px';line.style.height=(endY-startY)+'px';line.style.left=x+'px';line.style.top=startY+'px';c.appendChild(line);
}

function drawUpArrow(fromId,toId){
    const from=document.getElementById(fromId),to=document.getElementById(toId),c=document.querySelector('.flow-container');
    if(!from||!to||!c)return;
    const f=from.getBoundingClientRect(),t=to.getBoundingClientRect(),cc=c.getBoundingClientRect();
    const x=f.left+f.width/2-cc.left;
    const startY=f.top-cc.top,endY=t.bottom-cc.top;
    const line=document.createElement('div');line.className='flow-line arrow-up';line.style.width='2px';line.style.height=(startY-endY)+'px';line.style.left=x+'px';line.style.top=endY+'px';c.appendChild(line);
}

function drawDownToMidLine(fromCardId,leftCardId,rightCardId,offsetX=0){
    const from=document.getElementById(fromCardId),left=document.getElementById(leftCardId),right=document.getElementById(rightCardId),c=document.querySelector('.flow-container');
    if(!from||!left||!right||!c)return;
    const f=from.getBoundingClientRect(),l=left.getBoundingClientRect(),r=right.getBoundingClientRect(),cc=c.getBoundingClientRect();
    const leftCenter=l.left+l.width/2,rightCenter=r.left+r.width/2,midX=leftCenter+(rightCenter-leftCenter)*0.45-cc.left+offsetX;
    const startY=f.bottom-cc.top,endY=l.top+l.height/2-cc.top;
    const line=document.createElement('div');line.className='flow-line';line.style.width='2px';line.style.height=(endY-startY)+'px';line.style.left=midX+'px';line.style.top=startY+'px';c.appendChild(line);
}

function drawAllLines(){
    document.querySelectorAll('.flow-line').forEach(l=>l.remove());

    // PO → Receive (line only)
    drawLine('po', 'receive', false);
    // Receive → Enter Bills Against Inventory (arrow)
    drawLine('receive', 'enter-ai');
    // Enter Bills → Pay Bills (arrow)
    drawLine('enter', 'pay');
    
    
    drawLine('quotes', 'creatinvoice');
    
    drawLine('creatinvoice', 'receivepayments');
    drawLine('receivepayments', 'recordsdeposit');
    drawLine('statementcharges', 'statements');
    
    
    drawDownArrow('enter', 'creatinvoice');
    

    // ↓ From bottom of Enter Bills Against Inventory
    // ↓ to middle of Enter Bills — Pay Bills line
    drawDownToMidLine('enter-ai', 'enter', 'pay');
    
    drawUpArrow('quotes', 'salesorder');
    drawUpArrow('salesorder', 'po');

}

window.addEventListener('load',drawAllLines);
window.addEventListener('resize',drawAllLines);
</script>
@endpush
