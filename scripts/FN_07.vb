Sub FN_06()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, strError, logFile, fso, file, timeStamp
    Dim test_id, emg_brk_app_bc, emg_brk_app_time, emg_brk_app_status, emg_brk_app_remark

    ' SQLite database path
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get SmartTag values
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")
    emg_brk_app_bc = HmiRuntime.SmartTags("TBL05_BC_VALUE")
    emg_brk_app_time = HmiRuntime.SmartTags("TBL05_TIME_VALUE")
    emg_brk_app_remark = HmiRuntime.SmartTags("TBL05_REMARK_VALUE")

    ' Convert 1/0 to FAIL/PASS
    If HmiRuntime.SmartTags("TBL05_STATUS_VALUE") = 0 Then
        emg_brk_app_status = "FAIL"
    Else
        emg_brk_app_status = "PASS"
    End If

    ' Create ADODB connection object
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_05 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists -> UPDATE
        sqlQuery = "UPDATE tbl_05 SET " & _
                   "emg_brk_app_bc='" & emg_brk_app_bc & "'," & _
                   "emg_brk_app_time='" & emg_brk_app_time & "'," & _
                   "emg_brk_app_status='" & emg_brk_app_status & "'," & _
                   "emg_brk_app_remark='" & emg_brk_app_remark & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists -> INSERT
        sqlQuery = "INSERT INTO tbl_05 (" & _
                   "id, emg_brk_app_bc, emg_brk_app_time, emg_brk_app_status, emg_brk_app_remark" & _
                   ") VALUES (" & _
                   test_id & ",'" & emg_brk_app_bc & "','" & emg_brk_app_time & "','" & emg_brk_app_status & "','" & emg_brk_app_remark & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "FN_06 Error: " & Err.Description
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
