Sub FN_02()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, strError, logFile, fso, file, timeStamp
    Dim test_id, bp_1, fp_1, bp_1_status, fp_1_status
    Dim bp_2, fp_2, bp_2_status, fp_2_status

    ' SQLite database path
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get SmartTag values
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")
    
    ' Reading Values for Set 1
    bp_1 = HmiRuntime.SmartTags("TBL01_BP1_VALUE")
    fp_1 = HmiRuntime.SmartTags("TBL01_FP1_VALUE")
    
    ' Reading Values for Set 2
    bp_2 = HmiRuntime.SmartTags("TBL01_BP2_VALUE")
    fp_2 = HmiRuntime.SmartTags("TBL01_FP2_VALUE")

    ' Convert 1/0 to FAIL/PASS for Set 1
    If HmiRuntime.SmartTags("TBL01_BP1_STATUS") = 0 Then
        bp_1_status = "FAIL"
    Else
        bp_1_status = "PASS"
    End If

    If HmiRuntime.SmartTags("TBL01_FP1_STATUS") = 0 Then
        fp_1_status = "FAIL"
    Else
        fp_1_status = "PASS"
    End If

    ' Convert 1/0 to FAIL/PASS for Set 2
    If HmiRuntime.SmartTags("TBL01_BP2_STATUS") = 0 Then
        bp_2_status = "FAIL"
    Else
        bp_2_status = "PASS"
    End If

    If HmiRuntime.SmartTags("TBL01_FP2_STATUS") = 0 Then
        fp_2_status = "FAIL"
    Else
        fp_2_status = "PASS"
    End If

    ' Create ADODB connection object
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_01 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists -> UPDATE
        sqlQuery = "UPDATE tbl_01 SET " & _
                   "bp_1='" & bp_1 & "'," & _
                   "fp_1='" & fp_1 & "'," & _
                   "bp_1_status='" & bp_1_status & "'," & _
                   "fp_1_status='" & fp_1_status & "'," & _
                   "bp_2='" & bp_2 & "'," & _
                   "fp_2='" & fp_2 & "'," & _
                   "bp_2_status='" & bp_2_status & "'," & _
                   "fp_2_status='" & fp_2_status & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists -> INSERT
        sqlQuery = "INSERT INTO tbl_01 (" & _
                   "id, bp_1, fp_1, bp_1_status, fp_1_status, bp_2, fp_2, bp_2_status, fp_2_status" & _
                   ") VALUES (" & _
                   test_id & ",'" & bp_1 & "','" & fp_1 & "','" & bp_1_status & "','" & fp_1_status & "','" & _
                   bp_2 & "','" & fp_2 & "','" & bp_2_status & "','" & fp_2_status & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "FN_02 Error: " & Err.Description
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
