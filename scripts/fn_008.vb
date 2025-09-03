Sub FN_008()

    On Error Resume Next

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, logFile, strError, fso, file, timeStamp
    Dim test_id, coach_no_marked_sick

    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")
    coach_no_marked_sick = HmiRuntime.SmartTags("OVERCH_COACH")

    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_lhb_06 WHERE id=" & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        sqlQuery = "UPDATE tbl_lhb_06 SET coach_no_marked_sick='" & coach_no_marked_sick & "' WHERE id=" & test_id
    Else
        sqlQuery = "INSERT INTO tbl_lhb_06 (id, coach_no_marked_sick) VALUES (" & test_id & ",'" & coach_no_marked_sick & "')"
    End If

    objConn.Execute sqlQuery

    If Err.Number <> 0 Then
        strError = "Error in FN_008: " & Err.Description
        timeStamp = Now
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub