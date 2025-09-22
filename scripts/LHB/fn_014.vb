Sub FN_014()

    On Error Resume Next

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, logFile, strError, fso, file, timeStamp
    Dim test_id
    Dim loose_component, display_99, perform_seq_test, check_caliper_arms
    Dim dv_release_time, total_cylinder, operative_cylinder, percentage

    ' Get DB and log paths from SmartTags
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get test ID
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")

    ' Read tag values and convert to text
    If HmiRuntime.SmartTags("LOOSE_COMPONENT") = True Then
        loose_component = "DONE"
    Else
        loose_component = "NOT DONE"
    End If

    If HmiRuntime.SmartTags("DISPLAY_99") = True Then
        display_99 = "OK"
    Else
        display_99 = "NOT OK"
    End If

    If HmiRuntime.SmartTags("PERFORM_SEQ_TEST") = True Then
        perform_seq_test = "OK"
    Else
        perform_seq_test = "NOT OK"
    End If

    If HmiRuntime.SmartTags("CHECK_CALIPER_ARMS") = True Then
        check_caliper_arms = "OK"
    Else
        check_caliper_arms = "NOT OK"
    End If

    ' New fields from SmartTags (numeric)
    dv_release_time = CInt(HmiRuntime.SmartTags("DV_RELEASE_TIME"))
    total_cylinder = CInt(HmiRuntime.SmartTags("TOTAL_CYLINDER"))
    operative_cylinder = CInt(HmiRuntime.SmartTags("OPERATIVE_CYLINDER"))
    percentage = Round(CDbl(HmiRuntime.SmartTags("PERCENTAGE")), 2)  ' two decimals

    ' Open DB Connection
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if record exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_lhb_12 WHERE id=" & test_id
    Set objRS = objConn.Execute(checkQuery)

    ' Insert or Update
    If objRS("cnt") > 0 Then
        sqlQuery = "UPDATE tbl_lhb_12 SET " & _
                   "loose_component='" & loose_component & "'," & _
                   "display_99='" & display_99 & "'," & _
                   "perform_seq_test='" & perform_seq_test & "'," & _
                   "check_caliper_arms='" & check_caliper_arms & "'," & _
                   "dv_release_time=" & dv_release_time & "," & _
                   "total_cylinder=" & total_cylinder & "," & _
                   "operative_cylinder=" & operative_cylinder & "," & _
                   "percentage=" & Replace(FormatNumber(percentage, 2), ",", ".") & " " & _
                   "WHERE id=" & test_id
    Else
        sqlQuery = "INSERT INTO tbl_lhb_12 " & _
                   "(id, loose_component, display_99, perform_seq_test, check_caliper_arms, dv_release_time, total_cylinder, operative_cylinder, percentage) VALUES (" & _
                   test_id & ",'" & loose_component & "','" & display_99 & "','" & perform_seq_test & "','" & check_caliper_arms & "'," & _
                   dv_release_time & "," & total_cylinder & "," & operative_cylinder & "," & Replace(FormatNumber(percentage, 2), ",", ".") & ")"
    End If

    ' Execute query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "Error in FN_014: " & Err.Description
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    ' Close objects
    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub
