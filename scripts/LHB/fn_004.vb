Sub FN_004()

    On Error Resume Next  ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, strError, logFile, fso, file, timeStamp
    Dim test_id, rel_coach, ar_charge, cr_charge
    Dim fr_bp, fr_fp, re_bp, re_fp

    ' SQLite database path
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get SmartTag values
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")

    ' REL_COACH value
    rel_coach = HmiRuntime.SmartTags("REL_COACH")

    ' Convert AR_CHRG_EMPTY to "charge" or "empty"
    If HmiRuntime.SmartTags("AR_CHRG_EMPTY") = True Then
        ar_charge = "charge"
    Else
        ar_charge = "empty"
    End If

    ' Convert CR_CHRG_EMPTY to "charge" or "empty"
    If HmiRuntime.SmartTags("CR_CHRG_EMPTY") = True Then
        cr_charge = "charge"
    Else
        cr_charge = "empty"
    End If

    ' Pressure values
    fr_bp = HmiRuntime.SmartTags("FR_BP_VALUE")
    fr_fp = HmiRuntime.SmartTags("FR_FP_VALUE")
    re_bp = HmiRuntime.SmartTags("RE_BP_VALUE")
    re_fp = HmiRuntime.SmartTags("RE_FP_VALUE")

    ' Create ADODB connection object
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_lhb_02 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists → UPDATE
        sqlQuery = "UPDATE tbl_lhb_02 SET " & _
                   "brake_released='" & rel_coach & "'," & _
                   "ar_chrg_empty='" & ar_charge & "'," & _
                   "cr_chrg_empty='" & cr_charge & "'," & _
                   "front_pwr_car_bp='" & fr_bp & "'," & _
                   "front_pwr_car_fp='" & fr_fp & "'," & _
                   "lslrd_pwr_car_bp='" & re_bp & "'," & _
                   "lslrd_pwr_car_fp='" & re_fp & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists → INSERT
        sqlQuery = "INSERT INTO tbl_lhb_02 (" & _
                   "id, brake_released, ar_chrg_empty, cr_chrg_empty, front_pwr_car_bp, front_pwr_car_fp, lslrd_pwr_car_bp, lslrd_pwr_car_fp" & _
                   ") VALUES (" & _
                   test_id & ",'" & rel_coach & "','" & ar_charge & "','" & cr_charge & "','" & fr_bp & "','" & fr_fp & "','" & re_bp & "','" & re_fp & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "FN_004 Error: " & Err.Description
        timeStamp = Now

        ' Log error in text file
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    ' Close connection
    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub
