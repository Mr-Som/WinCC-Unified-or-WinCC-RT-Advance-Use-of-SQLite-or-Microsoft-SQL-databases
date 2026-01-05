Sub FN_03()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, strError, logFile, fso, file, timeStamp
    Dim test_id, leakage_bp, leakage_fp, leakage_bp_status, leakage_fp_status

    ' SQLite database path
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get SmartTag values
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")
    leakage_bp = HmiRuntime.SmartTags("ISG_ACTUAL_VALUE_AI_1")
    leakage_fp = HmiRuntime.SmartTags("ISG_ACTUAL_VALUE_AI_2")

    ' Convert 1/0 to FAIL/PASS
    If HmiRuntime.SmartTags("ISG_STATUS_1") = 0 Then
        leakage_bp_status = "FAIL"
    Else
        leakage_bp_status = "PASS"
    End If

    If HmiRuntime.SmartTags("ISG_STATUS_2") = 0 Then
        leakage_fp_status = "FAIL"
    Else
        leakage_fp_status = "PASS"
    End If

    ' Create ADODB connection object
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_02 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists → UPDATE
        sqlQuery = "UPDATE tbl_02 SET " & _
                   "leakage_bp='" & leakage_bp & "'," & _
                   "leakage_fp='" & leakage_fp & "'," & _
                   "leakage_bp_status='" & leakage_bp_status & "'," & _
                   "leakage_fp_status='" & leakage_fp_status & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists → INSERT
        sqlQuery = "INSERT INTO tbl_02 (" & _
                   "id, leakage_bp, leakage_fp, leakage_bp_status, leakage_fp_status" & _
                   ") VALUES (" & _
                   test_id & ",'" & leakage_bp & "','" & leakage_fp & "','" & leakage_bp_status & "','" & leakage_fp_status & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "FN_03 Error: " & Err.Description
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