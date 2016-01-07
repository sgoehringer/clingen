<!--------- start Code addition block 2 of 4 ------------> 
       
       <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog"> 
          <!-- Modal 2 content-->
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" type="button" data-dismiss="modal">×</button>
              <h4 class="modal-title"><?=$page->title; ?></h4>
            </div>
            <div class="modal-body">
                          <p>The search interface is in its initial release, expect refinements. Currently, the Laboratory and Research Tabs return the same results as the Clinician Tab.</p>

              <p>When it is necessary the text of the concept is used rather than the code. However, this can result in suboptimal results. Adoption of the HL7 Infobutton Standard by genomic information resources will lead to improved search results.</p>
              <p><strong>User requested enhancements to contextual search coming soon! Please provide feedback for optimal search results to <a href="mailto:bret.heale@hsc.utah.edu">Bret Heale</a>.</strong></p>
            </div>
            <div class="modal-footer">
              <button class="btn btn-default"
												onclick="$('#myModal3').modal('show');" type="button"
												data-dismiss="modal">Examples of supported concepts</button>
              <button class="btn btn-default" type="button"
												data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal 3 -->
      <div class="modal fade" id="myModal3" role="dialog">
        <div class="modal-dialog"> 
          <!-- Modal 3 content-->
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" type="button" data-dismiss="modal">×</button>
              <h4 class="modal-title">Example of supported concepts</h4>
            </div>
            
            <div class="modal-body"><p>Using Standard Terminology enabled Resources can allow
              this list to rapidly be increased</p>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Common Concept Term</th>
                      <th>Terminology used</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>CYP2C9</td>
                      <td>HGNC gene symbol</td>
                    </tr>
                    <tr>
                      <td>VKORC1</td>
                      <td>HGNC gene symbol</td>
                    </tr>
                    <tr>
                      <td>CCND1</td>
                      <td>HGNC gene symbol</td>
                    </tr>
                    <tr>
                      <td>MECP2</td>
                      <td>HGNC gene symbol</td>
                    </tr>
                    <tr>
                      <td>BRCA2</td>
                      <td>HGNC gene symbol</td>
                    </tr>
                    <tr>
                      <td>ADRB2</td>
                      <td>HGNC gene symbol</td>
                    </tr>
                    <tr>
                      <td>CYP2C19</td>
                      <td>HGNC gene symbol</td>
                    </tr>
                    <tr>
                      <td>Neurofibromatosis type 1</td>
                      <td>OMIM disease</td>
                    </tr>
                    <tr>
                      <td>Neurofibromatosis type 2</td>
                      <td>OMIM disease</td>
                    </tr>
                    <tr>
                      <td>Tourette syndrome</td>
                      <td>OMIM disease</td>
                    </tr>
                    <tr>
                      <td>Rett syndrome</td>
                      <td>OMIM disease</td>
                    </tr>
                    <tr>
                      <td>Tamoxifen</td>
                      <td>RxNorm medication</td>
                    </tr>
                    <tr>
                      <td>Noltam</td>
                      <td>RxNorm medication</td>
                    </tr>
                    <tr>
                      <td>mercaptopurine</td>
                      <td>RxNorm medication</td>
                    </tr>
                    <tr>
                      <td>clopidogrel [Plavix]</td>
                      <td>RxNorm medication</td>
                    </tr>
                    <tr>
                      <td>Coumadin</td>
                      <td>RxNorm medication</td>
                    </tr>
                    <tr>
                      <td>Narfarin</td>
                      <td>RxNorm medication</td>
                    </tr>
                    <tr>
                      <td>Warfarin</td>
                      <td>RxNorm medication</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-default" type="button"
												data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!------------------ ui is now being integrated - no going back ------------------> 
      <!--------- end Code addition block 2 of 4 ------------>