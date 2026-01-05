Sub FN_07()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, strError, logFile, fso, file, timeStamp
    Dim test_id, rel_emg_brk_app_time, rel_emg_brk_app_status, rel_emg_brk_app_remark

    ' SQLite database path
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get SmartTag values
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")
    rel_emg_brk_app_time = HmiRuntime.SmartTags("TBL06_TIME_VALUE")
    rel_emg_brk_app_remark = HmiRuntime.SmartTags("TBL06_REMARK_VALUE")

    ' Convert 1/0 to FAIL/PASS
    If HmiRuntime.SmartTags("TBL06_STATUS_VALUE") = 0 Then
        rel_emg_brk_app_status = "FAIL"
    Else
        rel_emg_brk_app_status = "PASS"
    End If

    ' Create ADODB connection object
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_06 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists -> UPDATE
        sqlQuery = "UPDATE tbl_06 SET " & _
                   "rel_emg_brk_app_time='" & rel_emg_brk_app_time & "'," & _
                   "rel_emg_brk_app_status='" & rel_emg_brk_app_status & "'," & _
                   "rel_emg_brk_app_remark='" & rel_emg_brk_app_remark & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists -> INSERT
        sqlQuery = "INSERT INTO tbl_06 (" & _
                   "id, rel_emg_brk_app_time, rel_emg_brk_app_status, rel_emg_brk_app_remark" & _
                   ") VALUES (" & _
                   test_id & ",'" & rel_emg_brk_app_time & "','" & rel_emg_brk_app_status & "','" & rel_emg_brk_app_remark & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "FN_07 Error: " & Err.Description
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
