Sub FN_012()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, logFile, strError, fso, file, timeStamp
    Dim test_id, bp_leakage_value, fp_leakage_value

    ' Get DB and log paths from SmartTags
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get test ID
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")

    ' Validate test_id
    If IsEmpty(test_id) Or Not IsNumeric(test_id) Then
        strError = "Error in FN_012 : Invalid or missing test_id"
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
        Exit Sub
    End If

    ' Read tag values
    bp_leakage_value = Round(CDbl(HmiRuntime.SmartTags("BC2_V")), 2)
    fp_leakage_value = Round(CDbl(HmiRuntime.SmartTags("FP2_V")), 2)

    ' Validate numeric values
    If Not IsNumeric(bp_leakage_value) Or IsEmpty(bp_leakage_value) Then
        bp_leakage_value = 0 ' Default to 0 or adjust as needed
        strError = "Error in FN_012 : bp_leakage_value is invalid or missing"
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
        Exit Sub
    End If
    If Not IsNumeric(fp_leakage_value) Or IsEmpty(fp_leakage_value) Then
        fp_leakage_value = 0 ' Default to 0 or adjust as needed
        strError = "Error in FN_012 : fp_leakage_value is invalid or missing"
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
        Exit Sub
    End If

    ' Open DB Connection
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    If Err.Number <> 0 Then
        strError = "Error in FN_012 : Failed to connect to database - " & Err.Description
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
        Exit Sub
    End If

    ' Check if record exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_lhb_10 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If Err.Number <> 0 Then
        strError = "Error in FN_012 : Check query failed - " & Err.Description
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
        objConn.Close
        Set objConn = Nothing
        Exit Sub
    End If

    If objRS("cnt") > 0 Then
        ' If exists → UPDATE
        sqlQuery = "UPDATE tbl_lhb_10 SET " & _
                   "bp_leakage_value = " & bp_leakage_value & ", " & _
                   "fp_leakage_value = " & fp_leakage_value & " " & _
                   "WHERE id = " & test_id
    Else
        ' If not exists → INSERT
        sqlQuery = "INSERT INTO tbl_lhb_10 (id, bp_leakage_value, fp_leakage_value) VALUES (" & _
                   test_id & ", " & bp_leakage_value & ", " & fp_leakage_value & ")"
    End If

    ' Execute query
    objConn.Execute sqlQuery

    If Err.Number <> 0 Then
        strError = "Error in FN_012 : SQL execution failed - " & Err.Description & " | Query: " & sqlQuery
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
        objConn.Close
        Set objConn = Nothing
        Set objRS = Nothing
        Exit Sub
    End If

    ' Close objects
    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub